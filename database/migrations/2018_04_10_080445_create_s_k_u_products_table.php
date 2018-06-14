<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSKUProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_k_u_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchandise_id')->comment('产品id');
            $table->string('code', 18)->comment('规格产品编码');
            $table->text('images')->comment('图片数组');
            $table->float('origin_price')->default(0)->comment('原价');
            $table->float('sell_price')->default(0)->comment('售价');
            $table->float('cost_price')->default(0)->comment('成本价格');
            $table->float('factory_price')->default(0)->comment('工厂价格');
            $table->unsignedInteger('stock_num')->default(0)->comment('库存');
            $table->unsignedInteger('sell_num')->default('0')->comment('已售出数量');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0-下架 1-上架');
            $table->timestamps();
            $table->softDeletes();
            $table->index('merchandise_id');
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
        Schema::dropIfExists('s_k_u_products');
    }
}
