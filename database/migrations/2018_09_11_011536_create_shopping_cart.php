<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺ID');
            $table->unsignedInteger('user_id')->nullable()->default(null)->comment('买家会员id');
            $table->unsignedInteger('merchandise_id')->nullable()->default(null)->comment('产品id');
            $table->unsignedInteger('sku_product_id')->nullable()->default(null)->comment('规格产品ID');
            $table->unsignedInteger('quality')->default(1)->comment('订单产品数量');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('amount')->default(0)->comment('总价');
            $table->timestamps();
            $table->index('app_id');
            $table->index('shop_id');
            $table->index('merchandise_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_cart');
    }
}
