<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PabrikSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'PT. Mencari Cinta Sejati',
                'alamat' => 'Jl. Jomblo No. 99, Jakarta',
                'rekening' => '7778889990',
                'kontak' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Hati Ini Telah Dilukai',
                'alamat' => 'Jl. Galau Raya No. 45, Bandung',
                'rekening' => '7778889991',
                'kontak' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Cinta Tak Direstui',
                'alamat' => 'Jl. Drama No. 67, Surabaya',
                'rekening' => '7778889992',
                'kontak' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Mantan The Series',
                'alamat' => 'Jl. Kenangan No. 12, Medan',
                'rekening' => '7778889993',
                'kontak' => '084567890123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Status In A Relationship',
                'alamat' => 'Jl. PDKT No. 34, Semarang',
                'rekening' => '7778889994',
                'kontak' => '085678901234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Gabut Butuh Pekerjaan',
                'alamat' => 'Jl. Nganggur No. 56, Yogyakarta',
                'rekening' => '7778889995',
                'kontak' => '086789012345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Ghosting Mode On',
                'alamat' => 'Jl. Hilang No. 78, Malang',
                'rekening' => '7778889996',
                'kontak' => '087890123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Single Ready To Mingle',
                'alamat' => 'Jl. Jadian No. 90, Denpasar',
                'rekening' => '7778889997',
                'kontak' => '088901234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Move On Is Not Easy',
                'alamat' => 'Jl. Lupa No. 11, Makassar',
                'rekening' => '7778889998',
                'kontak' => '089012345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Friendzone Forever',
                'alamat' => 'Jl. Sahabat No. 22, Palembang',
                'rekening' => '7778889999',
                'kontak' => '081112223333',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Cuma Teman Tapi Mesra',
                'alamat' => 'Jl. TTM No. 33, Balikpapan',
                'rekening' => '7778880001',
                'kontak' => '081223334444',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Putus Nyambung Terus',
                'alamat' => 'Jl. On Off No. 44, Manado',
                'rekening' => '7778880002',
                'kontak' => '081334445555',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('pabriks')->insert($data);
    }
}