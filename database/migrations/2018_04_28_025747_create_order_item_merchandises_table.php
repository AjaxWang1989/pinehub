<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrderItemMerchandisesTable.
 */
class CreateOrderItemMerchandisesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_item_merchandises', function(Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺ID');
            $table->unsignedInteger('member_id')->nullable()->default(null)->comment('买家会员id');
            $table->unsignedInteger('customer_id')->nullable()->default(null)->comment('买家ID');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->unsignedInteger('merchandise_id')->nullable()->default(null)->comment('产品id');
            $table->unsignedInteger('sku_product_id')->nullable()->default(null)->comment('规格产品ID');
            $table->string('name', 64)->nullable()->default(null)->comment('产品名称');
            $table->string('main_image')->nullable()->default(null)->comment('产品主图');
            $table->float('origin_price')->default(0)->comment('原价');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('cost_price')->default(0)->comment('成本价');
            $table->unsignedInteger('quality')->default(1)->comment('订单产品数量');
            $table->float('total_amount')->default(0)->comment('应付');
            $table->float('discount_amount')->default(0)->comment('优惠');
            $table->float('payment_amount')->default(0)->comment('实付');
            $table->unsignedInteger('status')->default(10)
                ->comment('订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成 ');
            $table->timestamp('signed_at')->nullable()->default(null)->comment('签收时间');
            $table->timestamp('consigned_at')->nullable()->default(null)->comment('发货时间');
            $table->timestamps();
            $table->index('customer_id');
            $table->index('shop_id');
            $table->index('order_id');
            $table->index('order_item_id');
            $table->index('merchandise_id');
            $table->index('sku_product_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_item_merchandises');
	}
}
