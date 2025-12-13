<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\Besi;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    /**
     * Tampilkan halaman Stock Opname
     */
    public function index()
    {
        $stockOpname = StockOpname::with('besi')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.stock_opname.index', compact('stockOpname'));
    }

    /**
     * Simpan data Stock Opname
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'besi_id'    => 'required|exists:besi,id',
            'stok_fisik' => 'required|integer|min:0',
        ]);

        // Ambil stok sistem langsung dari tabel besi
        $besi = Besi::findOrFail($request->besi_id);

        $stokSistem = $besi->stok;
        $stokFisik  = $request->stok_fisik;
        $selisih    = $stokSistem - $stokFisik;

        StockOpname::create([
            'tanggal'      => $request->tanggal,
            'besi_id'      => $besi->id,
            'stok_sistem'  => $stokSistem,
            'stok_fisik'   => $stokFisik,
            'selisih'      => $selisih,
        ]);

        return redirect()
            ->route('admin.stock-opname.index')
            ->with('success', 'Stock opname berhasil disimpan');
    }
}
