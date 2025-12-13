<?php

namespace App\Http\Controllers;

use App\Models\NotaDetail;
use App\Models\NotaDiskon;
use App\Models\Nota;
use App\Models\Diskon;
use App\Models\Timbangan;
use App\Models\Customer;
use App\Models\Pabrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        $timbangan = collect();

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $timbangan = Timbangan::with('besi')->whereIn('id', $ids)->get();
        }

        if ($timbangan->isEmpty()) {
            return view('components.error-nota');
        }

        return view('admin.nota.index', [
            'timbangan' => $timbangan,
            'pabrik'    => Pabrik::all(),
            'customer'  => Customer::all(),
            'diskon'    => Diskon::orderBy('nama')->get(),
        ]);
    }

public function cetak(Request $request)
{
    $timbangan = collect();

    if ($request->has('ids')) {
        $ids = explode(',', $request->ids);

        $timbangan = Timbangan::with(['besi', 'customer', 'pabrik'])
                    ->whereIn('id', $ids)
                    ->get();
    }

    if ($timbangan->isEmpty()) {
        return abort(404, 'Data timbangan tidak ditemukan');
    }

    // Ambil nota dari salah satu timbangan (asumsikan sama)
    $nota = $timbangan->first()->nota;

    if (!$nota) {
        return abort(404, 'Nota tidak ditemukan');
    }

    // Customer
    $customer = $timbangan->first()->customer;

    // =======================
    // 🔥 Perhitungan Total
    // =======================

    // SUBTOTAL
    $subtotal = $timbangan->sum(function($d){
        return ($d->besi->harga ?? 0) * $d->berat;
    });

    // Diskon global
    $diskonGlobal = $nota->diskons()->whereNull('nota_detail_id')->get();
    $totalDiskon = 0;
    $diskonList = [];
    foreach ($diskonGlobal as $d) {
        $nominal = $d->jenis === 'percent' ? $subtotal * ($d->nilai / 100) : $d->nilai;
        $totalDiskon += $nominal;
        $diskonList[] = [
            'nama' => $d->keterangan,
            'nominal' => $nominal,
        ];
    }

    // PPN (11%) setelah diskon
    $ppn = $nota->ppn ? ($subtotal - $totalDiskon) * 0.11 : 0;

    // Grand Total
    $grandTotal = $subtotal - $totalDiskon + $ppn;

    return view('admin.nota.cetak_nota', [
        'timbangan'     => $timbangan,
        'nota'          => $nota,
        'customer'      => $customer,

        // Variabel ringkasan total
        'subtotal'      => $subtotal,
        'diskonList'    => $diskonList,
        'totalDiskon'   => $totalDiskon,
        'ppn'           => $ppn,
        'grandTotal'    => $grandTotal,
    ]);
}



    public function create(Request $request)
    {
        return $this->index($request);
    }

    private function generateKodeNota($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('y', strtotime($tanggal));

        $urut = Nota::whereDate('tanggal_nota', $tanggal)->count() + 1;
        $urut3 = str_pad($urut, 3, '0', STR_PAD_LEFT);

        return "N{$bulan}{$tahun}{$urut3}";
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_nota'     => 'required|date',
            'jenis_pembayaran' => 'required|in:tunai,transfer,tempo',
            'ppn'              => 'boolean',
            'total_bayar'      => 'nullable|integer', // tidak wajib simpan
            'items'            => 'required|string',
            'customer_id'      => 'nullable|integer|exists:customers,id',
            'pabrik_id'        => 'nullable|integer|exists:pabriks,id',
            'jenis_nota'       => 'nullable|string|max:50',
            'diskon_id'        => 'nullable|integer|exists:diskons,id',
            'manual_diskon'    => 'nullable|array', // untuk diskon manual
        ]);

        // Parse items
        $items = json_decode($validated['items'], true);
        if (!$items || !is_array($items) || empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Items tidak valid atau kosong'
            ], 400);
        }

        // ================================
        // 🔥 Mapping jenis_nota FE → DB
        // ================================
        $mapJenisNota = [
            'Nota Pembelian' => 'pembelian',
            'Nota Penjualan' => 'penjualan',
        ];

        $jenisNotaInput = $validated['jenis_nota'] ?? null;
        $jenisNotaFinal = $mapJenisNota[$jenisNotaInput] ?? null;
        // ================================

        // Generate kode nota
        $kode_nota = $this->generateKodeNota($validated['tanggal_nota']);

        // Pastikan unik
        $maxAttempts = 5;
        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            if ($attempt > 0) {
                $kode_nota = $this->generateKodeNota($validated['tanggal_nota']) . '-' . rand(1000, 9999);
            }
            $existing = Nota::where('kode_nota', $kode_nota)->exists();
            if (!$existing) break;
        }

        DB::beginTransaction();

        try {
            // Buat Nota utama
            $nota = Nota::create([
                'kode_nota'        => $kode_nota,
                'tanggal_nota'     => $validated['tanggal_nota'],
                'jenis_nota'       => $jenisNotaFinal,
                'ppn'              => $request->boolean('ppn'),
                'customer_id'      => $validated['customer_id'] ?? null,
                'pabrik_id'        => $validated['pabrik_id'] ?? null,
                'user_id'          => \Illuminate\Support\Facades\Auth::id(),
                'jenis_pembayaran' => $validated['jenis_pembayaran'],
            ]);

            // Buat NotaDetail untuk setiap item
            foreach ($items as $item) {
                NotaDetail::create([
                    'nota_id'     => $nota->id,
                    'timbangan_id' => $item['id'] ?? null,
                    'besi_id'     => $item['besi_id'] ?? null,
                ]);
            }

            // Buat NotaDiskon untuk diskon global (master)
            if ($validated['diskon_id']) {
                $diskon = Diskon::find($validated['diskon_id']);
                if ($diskon) {
                    NotaDiskon::create([
                        'nota_id'       => $nota->id,
                        'diskon_id'     => $diskon->id,
                        'tipe'          => 'master',
                        'jenis'         => 'percent',
                        'nilai'         => $diskon->potongan,
                        'keterangan'    => $diskon->nama,
                    ]);
                }
            }

            // Untuk diskon manual (jika ada)
            if (!empty($validated['manual_diskon']) && is_array($validated['manual_diskon'])) {

    foreach ($validated['manual_diskon'] as $md) {

        // skip kalau nilai kosong atau 0
        if (empty($md['nilai']) || $md['nilai'] <= 0) {
            continue;
        }

        NotaDiskon::create([
            'nota_id'    => $nota->id,
            'tipe'       => 'custom',
            'jenis'      => $md['jenis'] ?? 'percent',
            'nilai'      => $md['nilai'],
            'keterangan' => $md['nama'] ?? 'Diskon Manual',
        ]);
    }
}

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success'   => true,
            'kode_nota' => $kode_nota,
            'nota_id'   => $nota->id,
        ]);
    }
}
