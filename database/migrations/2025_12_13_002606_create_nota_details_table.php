<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nota_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nota_id')
                  ->constrained('notas')
                  ->cascadeOnDelete();

            $table->foreignId('timbangan_id')
                  ->nullable()
                  ->constrained('timbangans')
                  ->nullOnDelete();

            // BONUS BESI (future use)
            $table->foreignId('besi_id')
                  ->nullable()
                  ->constrained('besi')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_details');
    }
};
