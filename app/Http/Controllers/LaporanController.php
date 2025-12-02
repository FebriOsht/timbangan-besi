<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timbangan;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    // ============================
    // LAPORAN PEMBELIAN (Barang Masuk)
    // ============================
    public function pembelian(Request $request)
    {
        $query = Timbangan::with(['besi', 'customer', 'pabrik'])
            ->where('status', 'Barang Masuk');

        if ($request->date_start) {
            $query->whereDate('tanggal', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->whereDate('tanggal', '<=', $request->date_end);
        }

        $data = $query->orderBy('tanggal', 'asc')->get();

        return response()->json($data);
    }

    // ============================
    // LAPORAN PENJUALAN (Barang Keluar)
    // ============================
    public function penjualan(Request $request)
    {
        $query = Timbangan::with(['besi', 'customer', 'pabrik'])
            ->where('status', 'Barang Keluar');

        if ($request->date_start) {
            $query->whereDate('tanggal', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->whereDate('tanggal', '<=', $request->date_end);
        }

        $data = $query->orderBy('tanggal', 'asc')->get();

        return response()->json($data);
    }
}
