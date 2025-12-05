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
        Schema::create('timbangans', function (Blueprint $table) {
            $table->id();

            // Kode Timbangan: TYYMM###
            $table->string('kode')->unique();

            // Relasi ke tabel besi
            $table->unsignedBigInteger('besi_id');

            // Berat yang ditimbang
            $table->decimal('berat', 10, 2);

            // Harga per kg (disimpan supaya tidak berubah jika harga besi update)
            $table->decimal('harga', 12, 2);

            // Status: Barang Masuk / Barang Keluar
            $table->enum('status', ['Barang Masuk', 'Barang Keluar'])->default('Barang Masuk');

            $table->timestamps();

            // Foreign Key ke tabel besi
            $table->foreign('besi_id')->references('id')->on('besi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timbangans');
    }
};
