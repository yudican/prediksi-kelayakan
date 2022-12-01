<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_set_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_set_id')->unsigned();
            $table->bigInteger('attribute_nilai_id')->unsigned();
            $table->timestamps();
            $table->foreign('data_set_id')->references('id')->on('data_set')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attribute_nilai_id')->references('id')->on('attribute_nilai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_set_detail');
    }
}
