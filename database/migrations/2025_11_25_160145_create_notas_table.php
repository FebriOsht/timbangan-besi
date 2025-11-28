<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('notas', function (Blueprint $table) {
        $table->id();

        $table->string('nomor_nota')->unique();
        $table->date('tanggal_nota');

        // langsung simpan nama supplier
        $table->string('nama_supplier')->nullable();

        $table->string('customer')->nullable();

        // Data Timbangan
        $table->string('nama_barang');
        $table->integer('harga_per_kg');
        $table->integer('total_berat');
        $table->integer('potongan')->default(0);

        // Pembayaran
        $table->enum('jenis_pembayaran', ['tunai', 'transfer', 'tempo'])->default('tunai');
        $table->integer('total_bayar')->default(0);

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
