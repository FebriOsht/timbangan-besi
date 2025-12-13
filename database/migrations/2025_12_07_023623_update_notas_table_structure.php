<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {

            // HAPUS KOLOM LAMA (jika ada)
            $dropColumns = [
                'nomor_nota', 'nama_supplier', 'customer', 'nama_barang',
                'harga_per_kg', 'total_berat', 'potongan', 'total_bayar', 'jenis_pembayaran'
            ];

            foreach ($dropColumns as $col) {
                if (Schema::hasColumn('notas', $col)) {
                    $table->dropColumn($col);
                }
            }

            // TAMBAH KOLOM BARU
            $table->string('kode_nota')->unique()->after('id');

            $table->foreignId('besi_id')->nullable()->constrained('besi')->nullOnDelete();
            $table->foreignId('timbangan_id')->nullable()->constrained('timbangans')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('pabrik_id')->nullable()->constrained('pabriks')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('jenis_pembayaran', ['Tunai', 'Transfer', 'Tempo'])
                ->default('Tunai');

            $table->integer('total_bayar')->default(0);

            

            $table->enum('jenis_nota', ['Pembelian', 'Penjualan'])
                ->default('Pembelian');

            $table->boolean('ppn')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {

            // Balikkan perubahan
            $table->dropColumn([
                'kode_nota',
                'besi_id',
                'timbangan_id',
                'customer_id',
                'pabrik_id',
                'user_id',
                'jenis_pembayaran',
                'total_bayar',
                'jenis_nota',
                'ppn',
            ]);

            // (Optional) kembalikan kolom lama jika mau
            $table->string('nomor_nota')->nullable();
            $table->string('nama_supplier')->nullable();
            $table->string('customer')->nullable();
            $table->string('nama_barang')->nullable();
            $table->integer('harga_per_kg')->nullable();
            $table->integer('total_berat')->nullable();
            $table->integer('potongan')->nullable();
            $table->integer('total_bayar')->nullable();
        });
    }
};
