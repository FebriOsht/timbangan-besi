<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BesiController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        // urutkan terbaru
        $data = Besi::orderBy('created_at', 'desc')->get();

        return view('admin.master.besi.index', compact('data'));
    }

    /**
     * Generate Kode Besi
     * Format: B + bulan + tahun + nomor urut 3 digit
     * Contoh: B1125001
     */
    private function generateKodeBesi()
    {
        $now = Carbon::now();
        $prefix = 'B' . $now->format('my'); // B1125

        // hitung total besi bulan ini
        $count = Besi::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        // next counter
        $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }

    /**
     * Store data besi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'stok'  => 'required|numeric',
        ]);

        $kode = $this->generateKodeBesi();

        Besi::create([
            'kode'  => $kode,
            'nama'  => $request->nama,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'stok'  => $request->stok,
        ]);

        return back()->with('success_kode', $kode);
    }

    /**
     * Update harga & stok besi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric',
            'stok'  => 'required|numeric',
        ]);

        $besi = Besi::findOrFail($id);

        // update hanya harga & stok sesuai permintaan
        $besi->update([
            'harga' => $request->harga,
            'stok'  => $request->stok,
        ]);

        return back()->with('success_update', $besi->kode);
    }

    /**
     * Delete data besi
     */
    public function destroy($id)
    {
        Besi::findOrFail($id)->delete();

        return back()->with('success', 'Data besi berhasil dihapus!');
    }
}
