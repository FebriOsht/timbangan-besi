<?php

namespace App\Http\Controllers;

use App\Models\Besi;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function chartData()
    {
        $today = Carbon::today();

        // 7 HARI TERAKHIR (TERMASUK HARI INI)
        $dates = collect(range(6, 0))->map(
            fn($i) =>
            $today->copy()->subDays($i)->toDateString()
        );

        $data = Timbangan::select(
            DB::raw('DATE(tanggal) as label'),
            DB::raw("SUM(CASE WHEN status = 'Barang Masuk' THEN berat ELSE 0 END) as masuk"),
            DB::raw("SUM(CASE WHEN status = 'Barang Keluar' THEN berat ELSE 0 END) as keluar")
        )
            ->whereBetween('tanggal', [
                $today->copy()->subDays(6)->startOfDay(),
                $today->copy()->endOfDay()
            ])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->get()
            ->keyBy('label');

        return response()->json([
            'labels' => $dates->map(
                fn($d) =>
                Carbon::parse($d)->format('d M')
            ),
            'masuk' => $dates->map(
                fn($d) =>
                (int) ($data[$d]->masuk ?? 0)
            ),
            'keluar' => $dates->map(
                fn($d) =>
                (int) ($data[$d]->keluar ?? 0)
            ),
        ]);
    }
    public function jenisBesiChart()
    {
        $data = Besi::select(
            'jenis',
            DB::raw('SUM(stok) as total_stok')
        )
            ->groupBy('jenis')
            ->get();

        return response()->json([
            'labels' => $data->pluck('jenis'),
            'data'   => $data->pluck('total_stok'),
        ]);
    }
}
