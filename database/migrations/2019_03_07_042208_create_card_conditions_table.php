<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCardConditionsTable.
 */
class CreateCardConditionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('card_conditions', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id')->comment('卡券ID');
            $table->boolean('paid')->default(false)->comment('支付可领取');
            $table->unsignedInteger('merchandise_id')->default(null)->comment('商品ID');
            $table->unsignedInteger('shop_id')->default(null)->comment('指定店铺id');
            $table->float('pre_payment_amount')->default(0)->comment('单笔支付满额领取');
            $table->unsignedTinyInteger('loop')->default(0)->comment('周期（天）');
            $table->unsignedTinyInteger('loop_order_num')->default(0)->comment('周期内购买多少单');
            $table->unsignedTinyInteger('loop_order_amount')->default(0)->comment('周期内消费总额');
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
		Schema::drop('card_conditions');
	}
}
