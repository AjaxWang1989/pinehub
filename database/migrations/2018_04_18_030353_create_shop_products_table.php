<?php

use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateShopProductsTable.
 */
class CreateShopProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_products', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->comment('店铺id');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->unsignedInteger('sku_product_id')->nullable()->comment('sku单品ID');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存');
            $table->unsignedInteger('sell_num')->default(0)->comment('销量');
            $table->unsignedTinyInteger('status')->default(0)->comment('1-上架 0-下架');
            $table->timestamps();
            $table->softDeletes();
            $table->index('shop_id');
            $table->index('merchandise_id');
            $table->index('sku_product_id');
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
		Schema::drop('shop_products');
	}
}
