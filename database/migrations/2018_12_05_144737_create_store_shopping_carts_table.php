<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_shopping_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id')->comment('系统app id');
            $table->string('name')->default('')->comment('常用购物车名称');
            $table->unsignedInteger('shop_id')->comment('店铺id');
            $table->json('shopping_carts')->comment('购物车');
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
        Schema::dropIfExists('store_shopping_carts');
    }
}
