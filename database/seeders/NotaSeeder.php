<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotaSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $counterPerBulan = [];

        for ($i = 1; $i <= 6; $i++) {

            // random tanggal (2 bulan terakhir biar realistis)
            $tanggal = Carbon::now()->subDays(rand(0, 60));

            $bulan = $tanggal->format('m'); // XX
            $tahun = $tanggal->format('y'); // YY
            $key = $bulan . $tahun;

            // counter ZZZ reset tiap bulan
            if (!isset($counterPerBulan[$key])) {
                $counterPerBulan[$key] = 1;
            }

            $urut = str_pad($counterPerBulan[$key], 3, '0', STR_PAD_LEFT);
            $kodeNota = "N{$bulan}{$tahun}{$urut}";

            $data[] = [
                'kode_nota'        => $kodeNota,
                'tanggal_nota'     => $tanggal,
                'jenis_nota'       => rand(0, 1) ? 'pembelian' : 'penjualan',
                'ppn'              => rand(0, 1), // boolean
                'customer_id'      => rand(1, 5),
                'pabrik_id'        => rand(1, 5),
                'user_id'          => rand(1, 2),
                'jenis_pembayaran' => collect(['tunai', 'tempo', 'transfer'])->random(),
                'created_at'       => $tanggal,
                'updated_at'       => $tanggal,
            ];

            $counterPerBulan[$key]++;
        }

        DB::table('notas')->insert($data);
    }
}
