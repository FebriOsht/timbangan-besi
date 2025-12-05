<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use App\Models\Besi;
use App\Models\Customer;
use App\Models\Pabrik;
use Illuminate\Http\Request;

class MutasiStockController extends Controller
{
    /**
     * Halaman utama Mutasi Stock
     */
    public function index()
    {
        $mutasi = Timbangan::with(['besi', 'customer', 'pabrik'])
                ->orderBy('created_at', 'desc')
                ->get();

        $besi      = Besi::orderBy('nama')->get();
        $customer  = Customer::orderBy('nama')->get();
        $pabrik    = Pabrik::orderBy('nama')->get();

        return view('admin.mutasi_stock.index', compact('mutasi', 'besi', 'customer', 'pabrik'));
    }

    /**
     * API untuk table AJAX (jika diperlukan)
     */
    public function getData()
    {
        $data = Timbangan::with(['besi', 'customer', 'pabrik'])
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json(['data' => $data]);
    }

    /**
     * Hapus Data Mutasi
     */
    public function destroy($id)
    {
        Timbangan::findOrFail($id)->delete();
        return back()->with('success', 'Data mutasi stock berhasil dihapus!');
    }

    /**
     * Tambah Mutasi Stock
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

        // === UPDATE STOK ===
        if ($status === "Barang Masuk") {
            $besi->stok += $request->berat;
        } else {
            if ($besi->stok < $request->berat) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $besi->stok -= $request->berat;
        }
        $besi->save();

        // === GENERATE KODE MUTASI OTOMATIS ===
        $kode = "MT-" . now()->format('YmdHis');

        // === SIMPAN DATA TIMBANGAN ===
        Timbangan::create([
            'kode'        => $kode,
            'besi_id'     => $besi->id,
            'berat'       => $request->berat,
            'harga'       => $besi->harga,
            'status'      => $status,
            'customer_id' => $request->customer_id,
            'pabrik_id'   => $request->pabrik_id,
            'tanggal'     => $request->tanggal,
        ]);

        return back()
            ->with('success', "Mutasi stock berhasil ditambahkan!")
            ->with('success_kode', $kode);
    }
}

