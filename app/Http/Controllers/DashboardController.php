<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalBesiBerstock = Besi::where('stok', '>', 0)->count();

        $totalPembelianHariIni = Timbangan::where('status', 'Barang Masuk')
            ->whereDate('tanggal', $today)
            ->sum('berat');

        $totalPenjualanHariIni = Timbangan::where('status', 'Barang Keluar')
            ->whereDate('tanggal', $today)
            ->sum('berat');

        $totalMutasiHariIni = Timbangan::whereDate('tanggal', $today)->count();

        $nilaiTotalStok = Besi::selectRaw('SUM(stok * harga) as total')->value('total');

        $transaksiTerbaru = Timbangan::with(['besi', 'customer'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalBesiBerstock',
            'totalPembelianHariIni',
            'totalPenjualanHariIni',
            'totalMutasiHariIni',
            'nilaiTotalStok',
            'transaksiTerbaru'
        ));
    }
}