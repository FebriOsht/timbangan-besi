<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $diskons = [
            ['nama' => 'Lebaran', 'potongan' => 15],
            ['nama' => 'Natal', 'potongan' => 20],
            ['nama' => 'Tahun Baru', 'potongan' => 10],
            ['nama' => 'HUT RI', 'potongan' => 17],
            ['nama' => 'Harbolnas', 'potongan' => 25],
            ['nama' => 'Black Friday', 'potongan' => 30],
            ['nama' => 'Chinese New Year', 'potongan' => 12],
            ['nama' => 'Valentine Day', 'potongan' => 18],
            ['nama' => 'Hari Pahlawan', 'potongan' => 15],
        ];

        $createdAt = Carbon::now();
        $bulan = $createdAt->format('m'); // XX
        $tahun = $createdAt->format('y'); // YY

        $data = [];
        $counter = 1;

        foreach ($diskons as $diskon) {

            $kodeDiskon = 'D'
                . $bulan
                . $tahun
                . str_pad($counter, 3, '0', STR_PAD_LEFT);

            $data[] = [
                'kode_diskon' => $kodeDiskon,
                'nama'        => $diskon['nama'],
                'potongan'    => $diskon['potongan'],
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ];

            $counter++;
        }

        DB::table('diskons')->insert($data);
    }
}
