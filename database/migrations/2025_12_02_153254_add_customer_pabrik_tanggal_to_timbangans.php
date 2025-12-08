<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('timbangans', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->after('harga');
            $table->unsignedBigInteger('pabrik_id')->after('customer_id');
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE'))->after('is_transfer');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('pabrik_id')->references('id')->on('pabriks')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('timbangans', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['pabrik_id']);
            $table->dropColumn(['customer_id','pabrik_id','tanggal']);
        });
    }
};
