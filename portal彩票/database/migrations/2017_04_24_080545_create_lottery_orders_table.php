<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//保存所有彩票彩种的订单，不包括体育类型
        Schema::create('lottery_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //彩种
            $table->unsignedInteger('lottery_id')->references('id')->on('lottery');
            //购买期号
            $table->string('phase');
            //购买号码
            $table->string('key');
            //购买者
            $table->unsignedInteger('user_id')->references('id')->on('user');
            //投注数量
            $table->integer('leverage');
            //最终消费价格
            $table->integer('totalcost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_orders');
    }
}
