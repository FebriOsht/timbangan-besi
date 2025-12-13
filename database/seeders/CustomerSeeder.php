<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'nama'     => 'Budi Santoso',
                'alamat'   => 'Jl. Merdeka No. 123, Jakarta',
                'rekening' => '1234567890',
                'kontak'   => '081234567890',
            ],
            [
                'nama'     => 'Sari Indah',
                'alamat'   => 'Jl. Sudirman No. 45, Bandung',
                'rekening' => '2345678901',
                'kontak'   => '082345678901',
            ],
            [
                'nama'     => 'Ahmad Fauzi',
                'alamat'   => 'Jl. Gatot Subroto No. 67, Surabaya',
                'rekening' => '3456789012',
                'kontak'   => '083456789012',
            ],
            [
                'nama'     => 'Dewi Lestari',
                'alamat'   => 'Jl. Thamrin No. 89, Medan',
                'rekening' => '4567890123',
                'kontak'   => '084567890123',
            ],
            [
                'nama'     => 'Joko Widodo',
                'alamat'   => 'Jl. Asia Afrika No. 12, Bandung',
                'rekening' => '5678901234',
                'kontak'   => '085678901234',
            ],
        ];

        $createdAt = Carbon::now();
        $bulan = $createdAt->format('m'); // XX
        $tahun = $createdAt->format('y'); // YY

        $data = [];
        $counter = 1;

        foreach ($customers as $customer) {

            $kodeCustomer = 'C'
                . $bulan
                . $tahun
                . str_pad($counter, 3, '0', STR_PAD_LEFT);

            $data[] = [
                'kode_customer' => $kodeCustomer,
                'nama'          => $customer['nama'],
                'alamat'        => $customer['alamat'],
                'rekening'      => $customer['rekening'],
                'kontak'        => $customer['kontak'],
                'created_at'    => $createdAt,
                'updated_at'    => $createdAt,
            ];

            $counter++;
        }

        DB::table('customers')->insert($data);
    }
}
