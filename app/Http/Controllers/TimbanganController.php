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

    /**
     * STORE (dengan update stok otomatis)
     */
    public function store(Request $request)
    {
        $request->validate([
            'besi_id' => 'required|exists:besi,id',
            'berat'   => 'required|numeric',
            'status'  => 'required|in:Barang Masuk,Barang Keluar',
        ]);

        $besi = Besi::findOrFail($request->besi_id);

        // Status langsung disimpan sesuai enum
        $status = $request->status;

        // Update stok otomatis
        if ($status === "Barang Masuk") {
            $besi->stok += $request->berat;
        } else {
            if ($besi->stok < $request->berat) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $besi->stok -= $request->berat;
        }
        $besi->save();

        $kode = $this->generateKode();

        Timbangan::create([
            'kode'    => $kode,
            'besi_id' => $besi->id,
            'berat'   => $request->berat,
            'harga'   => $besi->harga,
            'status'  => $status
        ]);

        return back()->with('success', "Timbangan dengan kode $kode berhasil ditambahkan");
    }

    /**
     * UPDATE TIMBANGAN
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'besi_id' => 'required|exists:besi,id',
            'berat'   => 'required|numeric',
            'status'  => 'required|in:Barang Masuk,Barang Keluar'
        ]);

        $t = Timbangan::findOrFail($id);

        $oldBesi = Besi::findOrFail($t->besi_id);
        $newBesi = Besi::findOrFail($request->besi_id);

        $newStatus = $request->status;

        /** 
         * Balikkan efek lama terhadap stok
         */
        if ($t->status === "Barang Masuk") {
            $oldBesi->stok -= $t->berat;
        } else {
            $oldBesi->stok += $t->berat;
        }
        $oldBesi->save();

        /**
         * Terapkan stok baru
         */
        if ($newStatus === "Barang Masuk") {
            $newBesi->stok += $request->berat;
        } else {
            if ($newBesi->stok < $request->berat) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $newBesi->stok -= $request->berat;
        }
        $newBesi->save();

        // Update data
        $t->update([
            'besi_id' => $newBesi->id,
            'berat'   => $request->berat,
            'harga'   => $newBesi->harga,
            'status'  => $newStatus
        ]);

        return back()->with('success', "Timbangan $t->kode berhasil diupdate");
    }

    /**
     * DELETE TIMBANGAN
     */
    public function destroy($id)
    {
        $t = Timbangan::findOrFail($id);
        $besi = Besi::findOrFail($t->besi_id);

        // Kembalikan stok
        if ($t->status === "Barang Masuk") {
            $besi->stok -= $t->berat;
        } else {
            $besi->stok += $t->berat;
        }
        $besi->save();

        $t->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /**
     * CETAK
     * If `ids` query param is provided (JSON array), print only those records.
     * Otherwise print all.
     */
    public function cetak(Request $request)
    {
        $idsRaw = $request->query('ids');

        if ($idsRaw) {
            $ids = json_decode($idsRaw, true);

            if (!$ids || count($ids) === 0) {
                abort(404, "Tidak ada data yang dipilih");
            }

            $data = Timbangan::with('besi')->whereIn('id', $ids)->get();
            $totalBerat = $data->sum('berat');
        } else {
            $data = Timbangan::with('besi')->get();
            $totalBerat = Timbangan::sum('berat');
        }

        return view('admin.input_timbangan.cetak', compact('data', 'totalBerat'));
    }


    /**
     * SEARCH BESI
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
    /**
 * SET IS CETAK (multiple ID)
 */
public function setCetak(Request $request)
{
    $ids = $request->ids;

    if (!$ids || !is_array($ids)) {
        return response()->json(['message' => 'Tidak ada data yang dipilih'], 400);
    }

    Timbangan::whereIn('id', $ids)->update([
        'is_cetak' => true
    ]);

    return response()->json(['message' => 'Berhasil menandai sebagai sudah dicetak']);
}

/**
 * SET IS TRANSFER (multiple ID)
 */
public function setTransfer(Request $request)
{
    $ids = $request->ids;

    if (!$ids || !is_array($ids)) {
        return response()->json(['message' => 'Tidak ada data yang dipilih'], 400);
    }

    Timbangan::whereIn('id', $ids)->update([
        'is_transfer' => true
    ]);

    return response()->json(['message' => 'Berhasil menandai sebagai sudah ditransfer']);
}
public function markCetak(Request $request)
{
    $ids = $request->ids;

    Timbangan::whereIn('id', $ids)->update([
        'is_cetak' => 1
    ]);

    return response()->json([
        'success' => true
    ]);
}

public function getBesi($id)
{
    $besi = Besi::find($id);

    if(!$besi){
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success' => true,
        'data' => $besi
    ]);
}


}
