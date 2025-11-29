<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timbangans', function (Blueprint $table) {
            $table->boolean('is_cetak')
                ->default(false)
                ->after('status');

            $table->boolean('is_transfer')
                ->default(false)
                ->after('is_cetak');
        });
    }

    public function down(): void
    {
        Schema::table('timbangans', function (Blueprint $table) {
            $table->dropColumn(['is_cetak', 'is_transfer']);
        });
    }
};
