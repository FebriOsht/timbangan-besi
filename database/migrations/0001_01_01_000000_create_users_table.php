<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                
                // Nama lengkap
                // HAPUS ->after('id')
                $table->string('first_name')->nullable(); 
                // HAPUS ->after('first_name')
                $table->string('last_name')->nullable(); 

                // Phone
                // HAPUS ->after('email')
                $table->string('phone_code', 10)->nullable(); 
                // HAPUS ->after('phone_code')
                $table->string('phone_number', 30)->nullable(); 

                // Foto profil (path ke file)
                // HAPUS ->after('phone_number')
                $table->string('profile_photo')->nullable(); 
            });
            // ... (Schema::create untuk password_reset_tokens dan sessions tetap sama)
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });

            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
        
        // ... (fungsi down() tetap sama)

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
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
