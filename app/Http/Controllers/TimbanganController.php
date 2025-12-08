<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use App\Models\Besi;
use App\Models\Customer;
use App\Models\Pabrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimbanganController extends Controller
{
    public function index()
    {
        // load recent data, with relations for display
        $data = Timbangan::with(['besi', 'customer', 'pabrik'])->orderBy('created_at', 'desc')->get();

        // Also pass lists if you want (not strictly needed since we use AJAX search)
        $pabrik = Pabrik::orderBy('nama')->limit(200)->get();
        $customer = Customer::orderBy('nama')->limit(200)->get();

        return view('admin.input_timbangan.index', compact('data','pabrik','customer'));
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
            'besi_id'     => 'required|exists:besi,id',
            'berat'       => 'required|numeric',
            'status'      => 'required|in:Barang Masuk,Barang Keluar',
            'customer_id' => 'required|exists:customers,id',
            'pabrik_id'   => 'required|exists:pabriks,id',
            'tanggal'     => 'required|date',
        ]);

        $besi = Besi::findOrFail($request->besi_id);

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

        $t = Timbangan::create([
            'kode'       => $kode,
            'besi_id'    => $besi->id,
            'berat'      => $request->berat,
            'harga'      => $besi->harga,
            'status'     => $status,
            'customer_id'=> $request->customer_id,
            'pabrik_id'  => $request->pabrik_id,
            'tanggal'    => $request->tanggal,
        ]);

        return back()->with('success', "Timbangan dengan kode $kode berhasil ditambahkan")->with('success_kode', $kode);
    }

    /**
     * UPDATE TIMBANGAN
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'besi_id'     => 'required|exists:besi,id',
            'berat'       => 'required|numeric',
            'status'      => 'required|in:Barang Masuk,Barang Keluar',
            'customer_id' => 'required|exists:customers,id',
            'pabrik_id'   => 'required|exists:pabriks,id',
            'tanggal'     => 'required|date',
            'is_cetak'    => 'sometimes|in:0,1',
            'is_transfer' => 'sometimes|in:0,1',
        ]);

        $t = Timbangan::findOrFail($id);

        $oldBesi = Besi::findOrFail($t->besi_id);
        $newBesi = Besi::findOrFail($request->besi_id);

        $newStatus = $request->status;

        // Balikkan efek lama terhadap stok
        if ($t->status === "Barang Masuk") {
            $oldBesi->stok -= $t->berat;
        } else {
            $oldBesi->stok += $t->berat;
        }
        $oldBesi->save();

        // Terapkan stok baru
        if ($newStatus === "Barang Masuk") {
            $newBesi->stok += $request->berat;
        } else {
            if ($newBesi->stok < $request->berat) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $newBesi->stok -= $request->berat;
        }
        $newBesi->save();

        // Prepare update data
        $updateData = [
            'besi_id'    => $newBesi->id,
            'berat'      => $request->berat,
            'harga'      => $newBesi->harga,
            'status'     => $newStatus,
            'customer_id'=> $request->customer_id,
            'pabrik_id'  => $request->pabrik_id,
            'tanggal'    => $request->tanggal,
        ];

        // Add boolean fields if provided
        if ($request->has('is_cetak')) {
            $updateData['is_cetak'] = (bool) $request->is_cetak;
        }
        if ($request->has('is_transfer')) {
            $updateData['is_transfer'] = (bool) $request->is_transfer;
        }

        // Update data timbangan
        $t->update($updateData);

        return back()->with('success', "Timbangan {$t->kode} berhasil diupdate")->with('success_update', $t->kode);
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
     */
    public function cetak(Request $request)
    {
        $idsRaw = $request->query('ids');

        if ($idsRaw) {
            $ids = json_decode($idsRaw, true);

            if (!$ids || count($ids) === 0) {
                abort(404, "Tidak ada data yang dipilih");
            }

            $data = Timbangan::with(['besi','customer','pabrik'])->whereIn('id', $ids)->get();
            $totalBerat = $data->sum('berat');
        } else {
            $data = Timbangan::with(['besi','customer','pabrik'])->get();
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

        if (strlen($q) < 3) {
            return response()->json([]);
        }

        $data = Besi::where('nama', 'like', "%$q%")
                    ->orWhere('jenis', 'like', "%$q%")
                    ->limit(10)
                    ->get();

        return response()->json($data);
    }

    /**
     * SEARCH PABRIK
     */
    public function searchPabrik(Request $request)
    {
        $q = $request->q;
        if (strlen($q) < 3) return response()->json([]);

        $data = Pabrik::where('nama', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->limit(10)
                    ->get();

        return response()->json($data);
    }

    /**
     * SEARCH CUSTOMER
     */
    public function searchCustomer(Request $request)
    {
        $q = $request->q;
        if (strlen($q) < 3) return response()->json([]);

        $data = Customer::where('nama', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->limit(10)
                    ->get();

        return response()->json($data);
    }

    /**
     * MARK CETAK / TRANSFER
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

    /**
     * GET BESI (existing)
     */
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

    /**
     * GET TIMBANGAN (JSON) - dipakai untuk edit modal
     */
    public function getTimbangan($id)
    {
        $t = Timbangan::with(['besi','customer','pabrik'])->find($id);

        if(!$t){
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'data' => $t
        ]);
    }
}
