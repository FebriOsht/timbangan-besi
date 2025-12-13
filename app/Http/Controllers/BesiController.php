<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use App\Models\Pabrik;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BesiController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        // urutkan terbaru + load pabrik
        $data = Besi::with('pabrik')
            ->orderBy('created_at', 'desc')
            ->get();

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

        $count = Besi::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }

    /**
     * Store data besi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string',
            'jenis'      => 'required|string',
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'pabrik_id'  => 'nullable|exists:pabriks,id',
        ]);

        $kode = $this->generateKodeBesi();

        Besi::create([
            'kode'       => $kode,
            'nama'       => $request->nama,
            'jenis'      => $request->jenis,
            'harga'      => $request->harga,
            'stok'       => $request->stok,
            'pabrik_id'  => $request->pabrik_id,
        ]);

        return back()->with('success_kode', $kode);
    }

    /**
     * Update harga, stok & pabrik
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'pabrik_id'  => 'nullable|exists:pabriks,id',
        ]);

        $besi = Besi::findOrFail($id);

        $besi->update([
            'harga'      => $request->harga,
            'stok'       => $request->stok,
            'pabrik_id'  => $request->pabrik_id,
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
