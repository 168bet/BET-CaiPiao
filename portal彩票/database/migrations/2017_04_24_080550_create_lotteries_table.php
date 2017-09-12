<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//这里用于保存所有的彩种，包括体育的和彩票的
        Schema::create('lotteries', function (Blueprint $table) {
            $table->increments('id');
            //彩种缩写
            $table->string('slug')->unique();
            //彩种名
            $table->string('name');
            //每注单价
            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotteries');
    }
}
