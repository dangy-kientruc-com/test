<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hokhau extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hokhau',function (Blueprint  $table){
            $table->increments('id');
            $table->string('hk_cd');
            $table->integer('chuho_id');
            $table->string('dia_chi');
            $table->dateTime('ngay_cap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hokhau');
    }
}
