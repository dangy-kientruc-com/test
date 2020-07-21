<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Nhankhau extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhankhau',function(Blueprint  $table){
            $table->bigIncrements('id');
            $table->string('ho_ten');
            $table->dateTime('ngay_sinh');
            $table->dateTime('ngay_mat');
            $table->boolean('gioi_tinh');
            $table->string('quan_he');
            $table->string('email');
            $table->string('sdt');
            $table->dateTime('ngay_nhap_khau');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhankhau');
    }
}
