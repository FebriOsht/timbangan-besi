<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('besi', function (Blueprint $table) {
            $table->foreignId('pabrik_id')
                  ->after('id')
                  ->constrained('pabrik')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('besi', function (Blueprint $table) {
            $table->dropForeign(['pabrik_id']);
            $table->dropColumn('pabrik_id');
        });
    }
};
