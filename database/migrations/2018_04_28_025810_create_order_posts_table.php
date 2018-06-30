<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrderPostsTable.
 */
class CreateOrderPostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_posts', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺ID');
            $table->unsignedInteger('buyer_user_id')->nullable()->default(null)->comment('买家ID');
            $table->unsignedInteger('order_id')->comment('订单id');
            $table->unsignedInteger('order_item_id')->comment('子订单id');
            $table->string('post_no', 64)->nullable()->default(null)->comment('物流订单号');
            $table->string('post_code', 6)->nullable()->default(null)->comment('收货地址邮编');
            $table->string('post_name', 32)->nullable()->default(null)->comment('物流公司名称');
            $table->timestamps();
            $table->index('post_no');
            $table->index('buyer_user_id');
            $table->index('shop_id');
            $table->index('order_id');
            $table->index('order_item_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_posts');
	}
}
