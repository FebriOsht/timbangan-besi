<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PabrikSeeder extends Seeder
{
    public function run()
    {
        $pabriks = [
            ['nama' => 'PT. Mencari Cinta Sejati', 'alamat' => 'Jl. Jomblo No. 99, Jakarta', 'rekening' => '7778889990', 'kontak' => '081234567890'],
            ['nama' => 'PT. Hati Ini Telah Dilukai', 'alamat' => 'Jl. Galau Raya No. 45, Bandung', 'rekening' => '7778889991', 'kontak' => '082345678901'],
            ['nama' => 'PT. Cinta Tak Direstui', 'alamat' => 'Jl. Drama No. 67, Surabaya', 'rekening' => '7778889992', 'kontak' => '083456789012'],
            ['nama' => 'PT. Mantan The Series', 'alamat' => 'Jl. Kenangan No. 12, Medan', 'rekening' => '7778889993', 'kontak' => '084567890123'],
            ['nama' => 'PT. Status In A Relationship', 'alamat' => 'Jl. PDKT No. 34, Semarang', 'rekening' => '7778889994', 'kontak' => '085678901234'],
            ['nama' => 'PT. Gabut Butuh Pekerjaan', 'alamat' => 'Jl. Nganggur No. 56, Yogyakarta', 'rekening' => '7778889995', 'kontak' => '086789012345'],
            ['nama' => 'PT. Ghosting Mode On', 'alamat' => 'Jl. Hilang No. 78, Malang', 'rekening' => '7778889996', 'kontak' => '087890123456'],
            ['nama' => 'PT. Single Ready To Mingle', 'alamat' => 'Jl. Jadian No. 90, Denpasar', 'rekening' => '7778889997', 'kontak' => '088901234567'],
        ];

        $counterPerMonth = [];
        $data = [];

        foreach ($pabriks as $index => $pabrik) {

            // random created_at biar realistis (bulan bisa beda)
            $createdAt = Carbon::now()->subDays(rand(0, 60));

            $bulan = $createdAt->format('m');
            $tahun = $createdAt->format('y');
            $key = $bulan . $tahun;

            if (!isset($counterPerMonth[$key])) {
                $counterPerMonth[$key] = 1;
            }

            $urut = str_pad($counterPerMonth[$key], 3, '0', STR_PAD_LEFT);

            $kodePabrik = "P{$bulan}{$tahun}{$urut}";

            $data[] = [
                'kode_pabrik' => $kodePabrik,
                'nama'        => $pabrik['nama'],
                'alamat'      => $pabrik['alamat'],
                'rekening'    => $pabrik['rekening'],
                'kontak'      => $pabrik['kontak'],
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ];

            $counterPerMonth[$key]++;
        }

        DB::table('pabriks')->insert($data);
    }
}
