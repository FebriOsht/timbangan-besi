<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 7; $i++) {
            $data[] = [
                'nota_id'      => rand(1, 5),
                'timbangan_id' => rand(1, 5),
                'besi_id'      => rand(1, 5),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('nota_details')->insert($data);
    }
}
