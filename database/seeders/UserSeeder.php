<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // ===== ADMIN =====
            [
                'first_name'     => 'admin',
                'last_name'      => 'admin',
                'email'          => 'admin@example.com',
                'password'       => Hash::make('123456789'),
                'phone_code'     => '+62',
                'phone_number'   => '8110000001',
                'profile_photo'  => null,
                'role'           => 'admin',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // ===== USERS =====
            [
                'first_name'     => 'user',
                'last_name'      => 'user',
                'email'          => 'user1@example.com',
                'password'       => Hash::make('123456789'),
                'phone_code'     => '+62',
                'phone_number'   => '8110000002',
                'profile_photo'  => null,
                'role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'first_name'     => 'user',
                'last_name'      => 'user',
                'email'          => 'user2@example.com',
                'password'       => Hash::make('123456789'),
                'phone_code'     => '+62',
                'phone_number'   => '8110000003',
                'profile_photo'  => null,
                'role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'first_name'     => 'user',
                'last_name'      => 'user',
                'email'          => 'user3@example.com',
                'password'       => Hash::make('123456789'),
                'phone_code'     => '+62',
                'phone_number'   => '8110000004',
                'profile_photo'  => null,
                'role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
