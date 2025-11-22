<?php

namespace App\Http\Controllers;

use App\Models\Diskon;   // ← yang benar
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $data = Diskon::all();  
        return view('admin.master.diskon.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'potongan' => 'required|numeric'
        ]);

        Diskon::create($request->all());

        return back()->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $diskon->update($request->all());

        return back()->with('success', 'Diskon berhasil diupdate!');
    }

    public function destroy($id)
    {
        Diskon::findOrFail($id)->delete();
        return back()->with('success', 'Diskon berhasil dihapus!');
    }
}
