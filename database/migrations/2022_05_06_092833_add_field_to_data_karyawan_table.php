<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToDataKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_karyawan', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->string('eselon')->after('telepon')->nullable();
            $table->string('gol')->after('eselon')->nullable();
            $table->date('tmt')->after('gol')->nullable();
            $table->string('email')->after('tmt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_karyawan', function (Blueprint $table) {
            $table->string('alamat');
            $table->dropColumn('eselon');
            $table->dropColumn('gol');
            $table->dropColumn('tmt');
            $table->dropColumn('email');
        });
    }
}
