<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use Illuminate\Http\Request;

class TimbanganController extends Controller
{
    public function index()
    {
        $data = Timbangan::all();
        return view('admin.input_timbangan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'  => 'required',
            'jenis' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'status' => 'required'
        ]);

        Timbangan::create($request->all());

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $timbangan = Timbangan::findOrFail($id);
        $timbangan->update($request->all());

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Timbangan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
    $data = Timbangan::all();
    $totalBerat = Timbangan::sum('berat');

    return view('admin.input_timbangan.cetak', compact('data', 'totalBerat'));
}

}
