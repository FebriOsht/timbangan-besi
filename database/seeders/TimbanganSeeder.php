<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Besi;

class TimbanganSeeder extends Seeder
{
    public function run()
    {
        // Ambil 7 data besi acak dari database
        $besiSamples = Besi::inRandomOrder()->limit(7)->get();
        
        $data = [];
        
        foreach ($besiSamples as $index => $besi) {
            // Alternatif antara Barang Masuk dan Barang Keluar
            $status = $index % 2 == 0 ? 'Barang Masuk' : 'Barang Keluar';
            
            // Generate berat random (dalam kg)
            $berat = rand(50, 500);
            
            // Hitung harga total berdasarkan harga besi dan berat
            $hargaTotal = $berat * $besi->harga;
            
            $data[] = [
                'kode' => $besi->kode, // Ambil kode dari besi
                'jenis' => $besi->jenis, // Ambil jenis dari besi
                'berat' => (string) $berat, // Convert ke string sesuai migrasi
                'harga' => (string) $hargaTotal, // Convert ke string sesuai migrasi
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('timbangans')->insert($data);
    }
}