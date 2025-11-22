<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use Illuminate\Http\Request;

class BesiController extends Controller
{
    public function index()
    {
        $data = Besi::all();
        return view('admin.master.besi.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        Besi::create($request->all());

        return back()->with('success', 'Data besi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $besi = Besi::findOrFail($id);

        $besi->update($request->all());

        return back()->with('success', 'Data besi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Besi::findOrFail($id)->delete();

        return back()->with('success', 'Data besi berhasil dihapus!');
    }
}
