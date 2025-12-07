<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Timbangan;
use App\Models\Pabrik;
use App\Models\Customer;
use App\Models\Diskon;
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

        return view('admin.nota.cetak_nota', [
            'timbangan' => $timbangan
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
            'total_bayar'      => 'required|integer',
            'items'            => 'nullable|string',
            'customer_id'      => 'nullable|integer|exists:customers,id',
            'pabrik_id'        => 'nullable|integer|exists:pabriks,id',
            'besi_id'          => 'nullable|integer|exists:besi,id',
            'timbangan_id'     => 'nullable|integer|exists:timbangans,id',
            'jenis_nota'       => 'nullable|string|max:50',
        ]);

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

        // 🔥 Generate kode nota
        $kode_nota = $this->generateKodeNota($validated['tanggal_nota']);

        // Data awal
        $notaData = [
            'kode_nota'        => $kode_nota,
            'besi_id'          => $validated['besi_id'] ?? null,
            'timbangan_id'     => $validated['timbangan_id'] ?? null,
            'customer_id'      => $validated['customer_id'] ?? null,
            'pabrik_id'        => $validated['pabrik_id'] ?? null,
            'user_id'          => \Illuminate\Support\Facades\Auth::id(),
            'jenis_pembayaran' => $validated['jenis_pembayaran'],
            'total_bayar'      => $validated['total_bayar'],
            'tanggal_nota'     => $validated['tanggal_nota'],
            'jenis_nota'       => $jenisNotaFinal,
            'ppn'              => $request->boolean('ppn'),
        ];

        // Retry jika kode_nota bentrok
        $maxAttempts = 5;
        $lastException = null;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {

            DB::beginTransaction();

            try {
                if ($attempt > 0) {
                    $kode_nota = $this->generateKodeNota($validated['tanggal_nota']) . '-' . rand(1000, 9999);
                    $notaData['kode_nota'] = $kode_nota;
                }

                // Simpan Nota
                $nota = Nota::create($notaData);

                // ❗ Sesuai permintaan:
                // ❌ Tidak ada update nota_id di tabel timbangans
                // Data timbangan hanya digunakan sebagai sumber tampilan nota.

                DB::commit();
                $lastException = null;
                break;

            } catch (\Exception $e) {
                DB::rollBack();
                $lastException = $e;
                continue;
            }
        }

        if ($lastException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $lastException->getMessage()
                ], 500);
            }
            return back()->with('error', 'Gagal menyimpan nota: ' . $lastException->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'kode_nota' => $kode_nota,
                'nota_id'   => $nota->id,
            ]);
        }

        return back()->with('success', 'Nota berhasil disimpan.');
    }
}
