<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrderItemsTable.
 */
class CreateOrderItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function(Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺ID');
            $table->unsignedInteger('buyer_user_id')->nullable()->default(null)->comment('买家ID');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->string('code', 18)->comment('订单子项编码');
            $table->float('total_amount')->default(0)->comment('应付');
            $table->float('discount_amount')->default(0)->comment('优惠');
            $table->float('payment_amount')->default(0)->comment('实付');
            $table->unsignedInteger('status')->default(10)
                ->comment('订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成 ');
            $table->timestamp('signed_at')->nullable()->default(null)->comment('签收时间');
            $table->timestamp('consigned_at')->nullable()->default(null)->comment('发货时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('code');
            $table->index('buyer_user_id');
            $table->index('shop_id');
            $table->index('order_id');
            $table->index('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_items');
	}
}
