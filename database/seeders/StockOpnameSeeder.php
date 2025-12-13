<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockOpnameSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 9; $i++) {

            $createdAt = Carbon::now()->subDays(rand(0, 30));

            $data[] = [
                'tanggal'     => $createdAt->toDateString(),
                'besi_id'     => rand(1, 5),
                'stok_fisik'  => rand(100, 150),
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ];
        }

        DB::table('stock_opnames')->insert($data);
    }
}
