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
    public function chartData(Request $request)
    {
        $filter = $request->get('filter', 'harian');
        $today  = Carbon::today();

        if ($filter === 'harian') {

            // ===== HARIAN (7 HARI TERAKHIR) =====
            $dates = collect(range(6, 0))->map(
                fn($i) =>
                $today->copy()->subDays($i)->toDateString()
            );

            $raw = Timbangan::select(
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
                'labels' => $dates->map(fn($d) => Carbon::parse($d)->format('d M')),
                'masuk'  => $dates->map(fn($d) => (int) ($raw[$d]->masuk ?? 0)),
                'keluar' => $dates->map(fn($d) => (int) ($raw[$d]->keluar ?? 0)),
            ]);
        }

        if ($filter === 'mingguan') {

            // ===== MINGGUAN (7 HARI = 1 MINGGU, START DARI HARI INI) =====
            $labels = [];
            $masuk  = [];
            $keluar = [];

            for ($i = 3; $i >= 0; $i--) {
                $start = $today->copy()->subDays(($i + 1) * 7 - 1)->startOfDay();
                $end   = $today->copy()->subDays($i * 7)->endOfDay();

                $data = Timbangan::select(
                    DB::raw("SUM(CASE WHEN status = 'Barang Masuk' THEN berat ELSE 0 END) as masuk"),
                    DB::raw("SUM(CASE WHEN status = 'Barang Keluar' THEN berat ELSE 0 END) as keluar")
                )
                    ->whereBetween('tanggal', [$start, $end])
                    ->first();

                $labels[] = 'Minggu ' . (4 - $i);
                $masuk[]  = (int) ($data->masuk ?? 0);
                $keluar[] = (int) ($data->keluar ?? 0);
            }

            return response()->json([
                'labels' => $labels,
                'masuk'  => $masuk,
                'keluar' => $keluar,
            ]);
        }

        if ($filter === 'bulanan') {

            // ===== BULANAN =====
            $data = Timbangan::select(
                DB::raw("YEAR(tanggal) as year"),
                DB::raw("MONTH(tanggal) as month"),
                DB::raw("SUM(CASE WHEN status = 'Barang Masuk' THEN berat ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN status = 'Barang Keluar' THEN berat ELSE 0 END) as keluar")
            )
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            return response()->json([
                'labels' => $data->map(
                    fn($d) =>
                    Carbon::create($d->year, $d->month)->format('M Y')
                ),
                'masuk'  => $data->pluck('masuk')->map(fn($v) => (int) $v),
                'keluar' => $data->pluck('keluar')->map(fn($v) => (int) $v),
            ]);
        }
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
