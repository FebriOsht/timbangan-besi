<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            // Tambahkan kolom diskon_id
            $table->unsignedBigInteger('diskon_id')->nullable();

            // Relasi ke tabel diskons
            $table->foreign('diskon_id')
                  ->references('id')
                  ->on('diskons')
                  ->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['diskon_id']);

            // Hapus kolomnya
            $table->dropColumn('diskon_id');
        });
    }
};
