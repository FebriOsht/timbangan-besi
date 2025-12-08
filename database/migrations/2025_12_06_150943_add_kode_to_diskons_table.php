<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->string('kode_diskon')->unique()->after('id');
        });
    }

    public function down()
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->dropColumn('kode_diskon');
        });
    }
};
