<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRechargeableCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechargeable_cards', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 20)->comment('卡种名称');
            $table->unsignedInteger('category_id')->comment('产品类别');
            $table->unsignedInteger('amount')->default(0)->comment('卡内金额（分）');
            $table->unsignedInteger('price')->comment('售价（分）');
            $table->unsignedInteger('preferential_price')->comment('优惠价格（分）');
            $table->unsignedInteger('auto_renew_price')->comment('自动续费价格（分）');
            $table->unsignedTinyInteger('on_sale')->default(0)->comment('是否优惠');
            $table->unsignedTinyInteger('is_recommend')->default(0)->comment('是否推荐');
            $table->unsignedTinyInteger('discount')->default(100)->comment('卡种享受购买折扣（百分比）');
            $table->string('card_type', 10)->comment('卡种');
            $table->unsignedTinyInteger('type')->comment('卡种期限类型');
            $table->string('unit', 5)->comment('时间单位');
            $table->integer('count')->comment('有限期数量，结合时间单位');
            $table->json('usage_scenarios')->comment('使用场景，默认全场通用');
            $table->time('specified_start')->nullable()->default(null)->comment('特定时段开始/天');
            $table->time('specified_end')->nullable()->default(null)->comment('特定时段结束/天');
            $table->unsignedTinyInteger('status')->default(0)->comment('卡种状态，0=>暂未上架,11=>上架,12=>优惠,21=>删除');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序，升序，最大值255');

            $table->softDeletes();

            $table->timestamps();
        });

        DB::statement("alter table `rechargeable_cards` comment '储蓄卡/折扣卡/卡种'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rechargeable_cards');
    }
}
