<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->comment('店铺id');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->json('tags')->default('')->comment('标签');
            $table->unsignedInteger('product_id')->nullable()->default(null)->comment('sku单品ID');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存数量');
            $table->unsignedInteger('sell_num')->default(0)->comment('销售数量');
            $table->timestamps();
            $table->index('shop_id');
            $table->index('merchandise_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_merchandises');
    }
}
