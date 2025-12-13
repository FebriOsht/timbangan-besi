<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {

            // HAPUS FOREIGN KEY DULU
            if (Schema::hasColumn('notas', 'besi_id')) {
                $table->dropForeign(['besi_id']);
                $table->dropColumn('besi_id');
            }

            if (Schema::hasColumn('notas', 'timbangan_id')) {
                $table->dropForeign(['timbangan_id']);
                $table->dropColumn('timbangan_id');
            }

            if (Schema::hasColumn('notas', 'diskon_id')) {
                $table->dropForeign(['diskon_id']);
                $table->dropColumn('diskon_id');
            }

            if (Schema::hasColumn('notas', 'total')) {
                $table->dropColumn('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {

            $table->foreignId('besi_id')
                  ->nullable()
                  ->constrained('besi')
                  ->nullOnDelete();

            $table->foreignId('timbangan_id')
                  ->nullable()
                  ->constrained('timbangans')
                  ->nullOnDelete();

            $table->unsignedBigInteger('diskon_id')->nullable();
            $table->foreign('diskon_id')
                  ->references('id')
                  ->on('diskons')
                  ->nullOnDelete();

            $table->bigInteger('total')->nullable();
        });
    }
};
