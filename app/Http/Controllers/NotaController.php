<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use App\Models\Timbangan;

class NotaController extends Controller
{
    public function index()
    {
        return view('admin.nota.index');
        
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_nota'       => 'required|string',
            'tanggal_nota'     => 'required|date',
            'nama_supplier'    => 'nullable|string',
            'customer'         => 'nullable|string',
            'nama_barang'      => 'required|string',
            'harga_per_kg'     => 'required|integer',
            'total_berat'      => 'required|integer',
            'potongan'         => 'nullable|integer',
            'jenis_pembayaran' => 'required|in:tunai,transfer,tempo',
            'total_bayar'      => 'required|integer',
        ]);

        Nota::create($data);

        return redirect()->back()->with('success', 'Nota berhasil disimpan.');
    }
    public function create(Request $request)
{
    // Ambil banyak ID dari query string
    $ids = explode(',', $request->ids);

    // Ambil data timbangan dari database
    $timbangan = Timbangan::whereIn('id', $ids)->get();

    // Tampilkan halaman form Nota
    return view('admin.nota.index', [
        'timbangan' => $timbangan,
        'ids'       => $ids,
    ]);
}
    public function cetak()
{
    return view('admin.nota.cetak_nota');
}

}
