<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'rekening' => '1234567890',
                'kontak' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sari Indah',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'rekening' => '2345678901',
                'kontak' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'alamat' => 'Jl. Gatot Subroto No. 67, Surabaya',
                'rekening' => '3456789012',
                'kontak' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Lestari',
                'alamat' => 'Jl. Thamrin No. 89, Medan',
                'rekening' => '4567890123',
                'kontak' => '084567890123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Joko Widodo',
                'alamat' => 'Jl. Asia Afrika No. 12, Bandung',
                'rekening' => '5678901234',
                'kontak' => '085678901234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Maya Sari',
                'alamat' => 'Jl. Pemuda No. 34, Semarang',
                'rekening' => '6789012345',
                'kontak' => '086789012345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rudi Hartono',
                'alamat' => 'Jl. Pahlawan No. 56, Yogyakarta',
                'rekening' => '7890123456',
                'kontak' => '087890123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lina Marlina',
                'alamat' => 'Jl. Diponegoro No. 78, Malang',
                'rekening' => '8901234567',
                'kontak' => '088901234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hendra Setiawan',
                'alamat' => 'Jl. Gajah Mada No. 90, Denpasar',
                'rekening' => '9012345678',
                'kontak' => '089012345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fitriani',
                'alamat' => 'Jl. Ahmad Yani No. 11, Makassar',
                'rekening' => '0123456789',
                'kontak' => '081112223333',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Agus Salim',
                'alamat' => 'Jl. Sisingamangaraja No. 22, Palembang',
                'rekening' => '1122334455',
                'kontak' => '081223334444',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rina Amelia',
                'alamat' => 'Jl. Teuku Umar No. 33, Balikpapan',
                'rekening' => '2233445566',
                'kontak' => '081334445555',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fajar Nugroho',
                'alamat' => 'Jl. Hayam Wuruk No. 44, Manado',
                'rekening' => '3344556677',
                'kontak' => '081445556666',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dian Permata',
                'alamat' => 'Jl. Juanda No. 55, Samarinda',
                'rekening' => '4455667788',
                'kontak' => '081556667777',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eko Prasetyo',
                'alamat' => 'Jl. Veteran No. 66, Padang',
                'rekening' => '5566778899',
                'kontak' => '081667778888',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Nina Rosita',
                'alamat' => 'Jl. Merapi No. 77, Bogor',
                'rekening' => '6677889900',
                'kontak' => '081778889999',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Irwan Susanto',
                'alamat' => 'Jl. Bromo No. 88, Tangerang',
                'rekening' => '7788990011',
                'kontak' => '081889990000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('customers')->insert($data);
    }
}