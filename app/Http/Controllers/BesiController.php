<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BesiController extends Controller
{
    public function index()
    {
        $data = Besi::all();
        return view('admin.master.besi.index', compact('data'));
    }

    // ===============================
    // GENERATE KODE OTOMATIS
    // ===============================
    private function generateKodeBesi()
    {
        $now = Carbon::now();
        $prefix = 'B' . $now->format('my'); // B + month(2) + year(2), contoh: B1125

        // hitung stok bulan ini
        $count = Besi::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        // nomor urut + 1
        $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $number; // contoh: B1125001
    }

    // =======================
    // STORE
    // =======================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $kode = $this->generateKodeBesi();

        Besi::create([
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        return back()->with('success_kode', $kode);
    }

    // =======================
    // UPDATE
    // =======================
    public function update(Request $request, $id)
    {
        $besi = Besi::findOrFail($id);
        $besi->update($request->all());

        $request->validate([
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        // hanya update harga dan stok (sesuai permintaan)
        $besi->update([
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return back()->with('success_update', $besi->kode);
    }

    // =======================
    // DELETE
    // =======================
    public function destroy($id)
    {
        Besi::findOrFail($id)->delete();
        return back()->with('success', 'Data besi berhasil dihapus!');
    }
}
