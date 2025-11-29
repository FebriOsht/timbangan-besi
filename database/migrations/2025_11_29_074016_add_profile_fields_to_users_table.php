<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nama lengkap
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');

            // Phone
            $table->string('phone_code', 10)->nullable()->after('email');
            $table->string('phone_number', 30)->nullable()->after('phone_code');

            // Foto profil (path ke file)
            $table->string('profile_photo')->nullable()->after('phone_number');

            // // Role user
            // $table->enum('role', ['admin', 'user'])->default('user')->after('profile_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone_code',
                'phone_number',
                'profile_photo'
                // 'role'
            ]);
        });
    }
};
