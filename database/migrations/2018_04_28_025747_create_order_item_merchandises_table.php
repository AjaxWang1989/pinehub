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
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺ID');
            $table->unsignedInteger('buyer_id,')->nullable()->default(null)->comment('买家ID');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->unsignedInteger('order_item_id')->comment('子订单id');
            $table->unsignedInteger('merchandise_id')->nullable()->default(null)->comment('产品id');
            $table->unsignedInteger('sku_product_id')->nullable()->default(null)->comment('规格产品ID');
            $table->string('name', 64)->nullable()->default(null)->comment('产品名称');
            $table->string('main_image')->nullable()->default(null)->comment('产品主图');
            $table->float('origin_price')->default(0)->comment('原价');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('cost_price')->default(0)->comment('成本价');
            $table->unsignedInteger('quality')->default(1)->comment('订单产品数量');
            $table->timestamps();
            $table->index('buyer_id,');
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
