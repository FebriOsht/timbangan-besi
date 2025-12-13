<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BesiSeeder extends Seeder
{
    public function run()
    {
        $jenisBesi = [
            'Besi Beton',
            'Besi Hollow',
            'Besi Siku',
            'Besi Plat',
            'Besi Wiremesh',
            'Besi UNP',
            'Besi CNP',
            'Besi Pipa'
        ];

        $data = [];

        // === SIMULASI TANGGAL CREATED (BULAN INI) ===
        $createdAt = Carbon::now();

        $bulan = $createdAt->format('m'); // XX
        $tahun = $createdAt->format('y'); // YY

        // Counter reset per bulan
        $counter = 1;

        // === HANYA 7 DATA ===
        for ($i = 1; $i <= 7; $i++) {

            $jenis = $jenisBesi[array_rand($jenisBesi)];

            $kode = 'B'
                . $bulan
                . $tahun
                . str_pad($counter, 3, '0', STR_PAD_LEFT);

            $data[] = [
                'kode'       => $kode,
                'nama'       => $jenis . ' ' . $this->generateRandomSpec(),
                'jenis'      => $jenis,
                'harga'      => $this->generateHarga($jenis),
                'stok'       => rand(10, 200),
                'pabrik_id'  => rand(1, 5),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            $counter++;
        }

        DB::table('besi')->insert($data);
    }

    private function generateRandomSpec()
    {
        $specs = [
            'Standard Grade',
            'High Tensile',
            'Galvanized',
            'Stainless',
            'Carbon Steel',
            'Alloy',
            'Baja Ringan',
            'Konstruksi',
            'Bangunan',
            'Industri',
            'Export Quality'
        ];

        $ukuran  = rand(6, 50) . 'mm';
        $panjang = rand(6, 12) . 'm';

        return $specs[array_rand($specs)] . ' ' . $ukuran . ' x ' . $panjang;
    }

    private function generateHarga($jenis)
    {
        $hargaRanges = [
            'Besi Beton'    => [50000, 150000],
            'Besi Hollow'   => [75000, 200000],
            'Besi Siku'     => [60000, 180000],
            'Besi Plat'     => [100000, 300000],
            'Besi Wiremesh' => [80000, 250000],
            'Besi UNP'      => [120000, 350000],
            'Besi CNP'      => [110000, 320000],
            'Besi Pipa'     => [90000, 280000],
        ];

        [$min, $max] = $hargaRanges[$jenis];

        return rand($min, $max);
    }
}
