<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->string('code', 16)->comment('产品编号');
            $table->string('name')->comment('产品名称');
            $table->string('main_image')->comment('主图');
            $table->json('tags')->default('')->comment('标签');
            $table->json('images')->default('')->comment('轮播图数组');
            $table->string('preview', 256)->comment('简介');
            $table->string('detail', 64000)->comment('详情');
            $table->float('origin_price')->default(0)->comment('原价');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('cost_price')->default(0)->comment('成本价格');
            $table->float('factory_price')->default(0)->comment('工厂价格');
            $table->enum('type', MERCHANDISE_STATUS_COLLECTION)
                ->default(UNLIMITED_MERCHANDISE)
                ->comment('产品类型');
            $table->unsignedInteger('capacity')->default(0)->comment('产能（工厂生产能力）');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存');
            $table->unsignedInteger('sell_num')->default('0')->comment('已售出数量');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0-下架 1-上架');
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->softDeletes();
            $table->index('code');
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
        Schema::dropIfExists('merchandises');
    }
}
