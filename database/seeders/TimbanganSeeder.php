<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimbanganSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $counter = [];

        $tanggalGroups = [
            ['date' => Carbon::now(),            'jumlah' => 3],
            ['date' => Carbon::now()->subDays(7),  'jumlah' => 3],
            ['date' => Carbon::now()->subDays(32), 'jumlah' => 3],
            ['date' => Carbon::now()->subDays(61), 'jumlah' => 5],
        ];

        foreach ($tanggalGroups as $group) {
            for ($i = 1; $i <= $group['jumlah']; $i++) {

                $createdAt = $group['date']->copy();

                $bulan = $createdAt->format('m');
                $tahun = $createdAt->format('y');
                $key   = $bulan . $tahun;

                if (!isset($counter[$key])) {
                    $counter[$key] = 1;
                }

                $kode = 'T' . $bulan . $tahun . str_pad($counter[$key], 3, '0', STR_PAD_LEFT);

                $data[] = [
                    'kode'         => $kode,
                    'besi_id'      => rand(1, 5),
                    'berat'        => rand(100, 150),
                    'harga'        => rand(1_000_000, 15_000_000),
                    'status'       => rand(0, 1) ? 'Barang Masuk' : 'Barang Keluar',
                    'is_cetak'     => 0,
                    'is_transfer'  => 0,
                    'tanggal'      => $createdAt->toDateTimeString(),
                    'customer_id'  => rand(1, 5),
                    'pabrik_id'    => rand(1, 5),
                    'created_at'   => $createdAt,
                    'updated_at'   => $createdAt,
                ];

                $counter[$key]++;
            }
        }

        DB::table('timbangans')->insert($data);
    }
}
