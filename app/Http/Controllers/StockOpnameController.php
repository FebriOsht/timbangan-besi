<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\Besi;
use App\Models\Pabrik;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    /**
     * Tampilkan halaman Stock Opname
     */
    public function index()
    {
        $stockOpname = StockOpname::with(['besi', 'pabrik'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $pabrik = Pabrik::orderBy('nama')->get();

        return view('admin.stock_opname.index', compact('stockOpname', 'pabrik'));
    }

    /**
     * Simpan data Stock Opname
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'pabrik_id'  => 'required|exists:pabriks,id',
            'besi_id'    => 'required|exists:besi,id',
            'stok_fisik' => 'required|integer|min:0',
        ]);

        // Ambil data besi (stok sistem sumber utama)
        $besi = Besi::where('id', $request->besi_id)
                    ->where('pabrik_id', $request->pabrik_id)
                    ->firstOrFail();

        $stokSistem = $besi->stok;
        $stokFisik  = $request->stok_fisik;
        $selisih    = $stokSistem - $stokFisik;

        StockOpname::create([
            'tanggal'     => $request->tanggal,
            'pabrik_id'   => $request->pabrik_id,
            'besi_id'     => $besi->id,
            'stok_sistem' => $stokSistem,
            'stok_fisik'  => $stokFisik,
            'selisih'     => $selisih,
        ]);

        return redirect()
            ->route('admin.stock-opname.index')
            ->with('success', 'Stock opname berhasil disimpan');
    }

    /**
     * API: Ambil besi berdasarkan pabrik
     */
    public function besiByPabrik($pabrikId)
    {
        $besi = Besi::where('pabrik_id', $pabrikId)
            ->select('id', 'nama', 'jenis', 'stok')
            ->orderBy('nama')
            ->get();

        return response()->json($besi);
    }
}
