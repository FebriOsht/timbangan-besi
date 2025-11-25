<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

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
}
