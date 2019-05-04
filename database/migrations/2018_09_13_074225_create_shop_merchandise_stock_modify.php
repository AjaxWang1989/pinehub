<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopMerchandiseStockModify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_merchandise_stock_modify', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->comment('店铺id');
            $table->unsignedInteger('merchandise_id')->comment('商品ID');
            $table->unsignedInteger('product_id')->nullable()->default(null)->comment('sku单品ID');
            $table->unsignedInteger('primary_stock_num')->default(0)->comment('原库存数量');
            $table->unsignedInteger('modify_stock_num')->default(0)->comment('修改后库存数量');
            $table->string('reason', 100)->nullable()->default(null)->comment('修改原因');
            $table->string('comment', 100)->nullable()->default(null)->comment('备注');
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
        Schema::dropIfExists('shop_merchandise_stock_modify');
    }
}
