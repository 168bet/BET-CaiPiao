<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//保存所有彩票彩种的结果，不包括体育类型
        Schema::create('lottery_results', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //彩种
            $table->unsignedInteger('lottery_id')->references('id')->on('lottery');
            //期号
            $table->string('phase');
            //开奖号码
            $table->string('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_results');
    }
}
