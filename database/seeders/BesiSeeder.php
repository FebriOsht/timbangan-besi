<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BesiSeeder extends Seeder
{
    public function run()
    {
        $jenisBesi = [
            'Besi Beton' => 'BB',
            'Besi Hollow' => 'BH',
            'Besi Siku' => 'BS',
            'Besi Plat' => 'BP',
            'Besi Wiremesh' => 'BW',
            'Besi UNP' => 'BU',
            'Besi CNP' => 'BC',
            'Besi Pipa' => 'BIP'
        ];

        $data = [];
        $counter = [];
        
        foreach ($jenisBesi as $jenis => $inisial) {
            $counter[$jenis] = 1;
        }
        
        for ($i = 1; $i <= 13; $i++) {
            $jenis = array_rand($jenisBesi);
            $inisial = $jenisBesi[$jenis];
            $nomorUrut = str_pad($counter[$jenis], 2, '0', STR_PAD_LEFT);
            
            $data[] = [
                'kode' => $inisial . $nomorUrut,
                'nama' => $jenis . ' ' . $this->generateRandomSpec(),
                'jenis' => $jenis,
                'harga' => $this->generateHarga($jenis),
                'stok' => rand(10, 200),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $counter[$jenis]++;
        }

        DB::table('besi')->insert($data);
    }

    private function generateRandomSpec()
    {
        $specs = [
            'Standard Grade', 'High Tensile', 'Galvanized', 'Stainless', 
            'Carbon Steel', 'Alloy', 'Baja Ringan', 'Konstruksi', 
            'Bangunan', 'Industri', 'Export Quality'
        ];
        
        $ukuran = rand(1, 50) . 'mm';
        $panjang = rand(6, 12) . 'm';
        
        return $specs[array_rand($specs)] . ' ' . $ukuran . ' x ' . $panjang;
    }

    private function generateHarga($jenis)
    {
        $hargaRanges = [
            'Besi Beton' => [50000, 150000],
            'Besi Hollow' => [75000, 200000],
            'Besi Siku' => [60000, 180000],
            'Besi Plat' => [100000, 300000],
            'Besi Wiremesh' => [80000, 250000],
            'Besi UNP' => [120000, 350000],
            'Besi CNP' => [110000, 320000],
            'Besi Pipa' => [90000, 280000]
        ];

        $range = $hargaRanges[$jenis];
        return rand($range[0], $range[1]);
    }
}