<?php

namespace App\Http\Controllers;

use App\Models\Pabrik;
use Illuminate\Http\Request;

class PabrikController extends Controller
{
    public function index()
    {
        return view('admin.master.pabrik.index', [
            'pabriks' => Pabrik::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        Pabrik::create($request->all());

        return back()->with('success', 'Pabrik berhasil ditambahkan!');
    }

    public function update(Request $request, Pabrik $pabrik)
    {
        $pabrik->update($request->all());

        return back()->with('success', 'Pabrik berhasil diperbarui!');
    }

    public function destroy(Pabrik $pabrik)
    {
        $pabrik->delete();

        return back()->with('success', 'Pabrik berhasil dihapus!');
    }
}

