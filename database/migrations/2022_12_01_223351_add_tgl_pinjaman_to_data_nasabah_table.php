<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglPinjamanToDataNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_nasabah', function (Blueprint $table) {
            $table->date('tgl_pinjaman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_nasabah', function (Blueprint $table) {
            $table->dropColumn('tgl_pinjaman');
        });
    }
}
