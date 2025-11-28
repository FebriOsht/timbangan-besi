<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use App\Models\Besi;
use Illuminate\Http\Request;

class TimbanganController extends Controller
{
    public function index()
    {
        $data = Timbangan::with('besi')->orderBy('created_at', 'desc')->get();
        return view('admin.input_timbangan.index', compact('data'));
    }

    /**
     * Generate kode otomatis: TYYMMXXX
     */
    private function generateKode()
    {
        $prefix = 'T';
        $year   = date('y');
        $month  = date('m');

        $last = Timbangan::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))
                    ->orderBy('id', 'desc')
                    ->first();

        $number = $last ? intval(substr($last->kode, 5)) + 1 : 1;

        return $prefix . $year . $month . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'besi_id' => 'required|exists:besi,id',
            'berat'   => 'required|numeric',
            'status'  => 'required|in:Barang Masuk,Barang Keluar',
        ]);

        // Ambil data besi
        $besi = Besi::findOrFail($request->besi_id);

        // Generate Kode
        $kode = $this->generateKode();

        // Simpan
        $timbangan = Timbangan::create([
            'kode'    => $kode,
            'besi_id' => $besi->id,
            'berat'   => $request->berat,
            'harga'   => $besi->harga, // harga disimpan agar tidak berubah ketika harga besi naik
            'status'  => $request->status
        ]);

        return back()->with('success', "Timbangan dengan kode $kode berhasil ditambahkan");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'besi_id' => 'required|exists:besi,id',
            'berat'   => 'required|numeric',
            'status'  => 'required|in:Barang Masuk,Barang Keluar'
        ]);

        $t = Timbangan::findOrFail($id);

        // Ambil harga baru dari tabel besi
        $besi = Besi::findOrFail($request->besi_id);

        $t->update([
            'besi_id' => $request->besi_id,
            'berat'   => $request->berat,
            'harga'   => $besi->harga,
            'status'  => $request->status
        ]);

        return back()->with('success', "Timbangan dengan ID $t->kode berhasil diupdate");
    }

    public function destroy($id)
    {
        Timbangan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
        $data = Timbangan::with('besi')->get();
        $totalBerat = Timbangan::sum('berat');

        return view('admin.input_timbangan.cetak', compact('data', 'totalBerat'));
    }

    /**
     * Search Besi untuk dropdown realtime (min 4 huruf)
     */
    public function searchBesi(Request $request)
    {
        $q = $request->q;

        if (strlen($q) < 4) {
            return response()->json([]);
        }

        $data = Besi::where('nama', 'like', "%$q%")
                        ->orWhere('jenis', 'like', "%$q%")
                        ->limit(10)
                        ->get();

        return response()->json($data);
    }
}
