<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Timbangan;
use App\Models\Pabrik;
use App\Models\Customer;
use App\Models\Diskon;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data timbangan jika ada "ids" dari transfer
        $timbangan = [];

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $timbangan = Timbangan::with('besi')->whereIn('id', $ids)->get();
        }

        // Jika tidak ada data timbangan, tampilkan halaman error
        if (empty($timbangan) || $timbangan->isEmpty()) {
            return view('components.error-nota');
        }

        return view('admin.nota.index', [
            'timbangan' => $timbangan,
            'pabrik'    => Pabrik::all(),
            'customer'  => Customer::all(),

            // List diskon untuk preload FE (opsional)
            'diskon'    => Diskon::orderBy('nama')->get(),
        ]);
    }

    /**
     * CREATE (alias untuk index dengan query params)
     * Digunakan saat transfer dari timbangan page
     */
    public function create(Request $request)
    {
        return $this->index($request);
    }

    public function store(Request $request)
    {
        // Data utama nota + hasil perhitungan dari FE
        $data = $request->validate([
            'nomor_nota'       => 'required|string',
            'tanggal_nota'     => 'required|date',

            'nama_supplier'    => 'nullable|string',
            'customer'         => 'nullable|string',

            // Barang utama
            'nama_barang'      => 'required|string',
            'harga_per_kg'     => 'required|integer',
            'potongan'         => 'nullable|integer',

            'jenis_pembayaran' => 'required|in:tunai,transfer,tempo',

            // Hasil akhir perhitungan FE
            'diskon_nama'      => 'nullable|string',
            'diskon_persen'    => 'nullable|integer',
            'ppn'              => 'boolean',
            'subtotal'         => 'required|integer',
            'total_ppn'        => 'required|integer',
            'grand_total'      => 'required|integer',

            'total_bayar'      => 'required|integer',

            // Items dalam bentuk JSON string (optional)
            'items'            => 'nullable|string',
        ]);

        // Simpan Nota
        $nota = Nota::create($data);

        // Jika nanti kamu ingin menyimpan item satu per satu:
        // $items = json_decode($request->items, true);
        // foreach ($items as $it) {
        //     NotaItem::create([
        //         'nota_id' => $nota->id,
        //         'nama'    => $it['nama'],
        //         'berat'   => $it['berat'],
        //         'harga'   => $it['harga'],
        //         'potongan'=> $it['potongan'],
        //         'total'   => $it['total'],
        //     ]);
        // }

        return redirect()->back()->with('success', 'Nota berhasil disimpan.');
    }

    public function cetak()
    {
        return view('admin.nota.cetak_nota');
    }
}
