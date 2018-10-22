<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id')->comment('活动ID');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺活动时显示的店铺ID');
            $table->unsignedInteger('shop_merchandise_id')->nullable()->default(null)->comment('店铺活动时显示的店铺产品ID');
            $table->unsignedInteger('merchandise_id')->comment('产品ID');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->unsignedInteger('product_id')->nullable()->default(null)->comment('sku单品ID');
            $table->integer('stock_num')->default(-1)->comment('参与活动的数量:-1无限制，大于0参与活动商品数量，0售罄');
            $table->integer('sell_num')->default(-1)->comment('已售出数量');
            $table->string('tags')->default('')->comment('产品标签');
            $table->string('describe')->default('')->comment('产品介绍');
            $table->timestamp('start_at')->nullable()->default(null)->comment('开售时间');
            $table->timestamp('end_at')->nullable()->default(null)->comment('结业时间');
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
        Schema::dropIfExists('activity_merchandises');
    }
}
