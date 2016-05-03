<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRobotOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robot_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->comment('订单号');
            $table->integer('user_id');
            $table->datetime('pay_time')->comment('订单付款时间');
            $table->integer('type')->comment('订单类型:1.VIP1包年 2.VIP2包月');
            $table->string('channel')->comment('渠道:1.APPStore 2.Android 3.Card');
            $table->float('price')->comment('价格');
            $table->integer('status')->comment('0:待付款 1:取消订单 2:已付款');
            $table->boolean('islocked')->comment('1:被锁定');
            $table->integer('operator')->comment('添加备注的人');
            $table->string('notes')->comment('备注内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('robot_orders');
    }
}
