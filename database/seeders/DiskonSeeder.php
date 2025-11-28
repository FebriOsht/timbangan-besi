<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Lebaran',
                'potongan' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Natal',
                'potongan' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tahun Baru',
                'potongan' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'HUT RI',
                'potongan' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Harbolnas',
                'potongan' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Black Friday',
                'potongan' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Chinese New Year',
                'potongan' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Valentine Day',
                'potongan' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hari Pahlawan',
                'potongan' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Summer Sale',
                'potongan' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('diskons')->insert($data);
    }
}