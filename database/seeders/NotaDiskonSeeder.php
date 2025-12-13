<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaDiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'nota_id'        => rand(1, 5),
                'nota_detail_id' => null,
                'diskon_id'      => rand(1, 5),
                'tipe'           => null,
                'jenis'          => null,
                'nilai'          => null,
                'keterangan'     => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('nota_diskons')->insert($data);
    }
}
