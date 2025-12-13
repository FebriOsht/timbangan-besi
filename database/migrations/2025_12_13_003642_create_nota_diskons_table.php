<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nota_diskons', function (Blueprint $table) {
            $table->id();

            // DISKON BISA PER NOTA ATAU PER DETAIL
            $table->foreignId('nota_id')
                  ->nullable()
                  ->constrained('notas')
                  ->cascadeOnDelete();

            $table->foreignId('nota_detail_id')
                  ->nullable()
                  ->constrained('nota_details')
                  ->cascadeOnDelete();

            // REFER KE MASTER DISKON (OPTIONAL)
            $table->foreignId('diskon_id')
                  ->nullable()
                  ->constrained('diskons')
                  ->nullOnDelete();

            // JIKA DISKON MANUAL
            $table->enum('tipe', ['master', 'custom'])->nullable();
            $table->enum('jenis', ['percent', 'nominal'])->nullable();
            $table->decimal('nilai', 12, 2)->nullable();

            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_diskons');
    }
};
