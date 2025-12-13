<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // ===== MASTER DATA =====
            UserSeeder::class,
            PabrikSeeder::class,
            CustomerSeeder::class,
            BesiSeeder::class,
            DiskonSeeder::class,

            // ===== TRANSAKSI =====
            TimbanganSeeder::class,
            NotaSeeder::class,
            NotaDetailSeeder::class,
            NotaDiskonSeeder::class,

            // ===== LAINNYA =====
            StockOpnameSeeder::class,
        ]);
    }
}
