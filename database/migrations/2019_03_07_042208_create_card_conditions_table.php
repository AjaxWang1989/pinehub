<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCardConditionsTable.
 */
class CreateCardConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['PUT', 'USE'])->comment('条件类型');
            $table->string('card_id', 32)->comment('卡券ID');
//            $table->boolean('paid')->default(false)->comment('支付可领取');
//            $table->unsignedInteger('merchandise_id')->default(null)->comment('商品ID');
            $table->json('valid_obj')->comment('作用对象["merchandises" => null, "shops" => null, "customers" => ["sex" => MALE/FEMALE, "tags" => null] ]');
            $table->json('show')->comment('投放/使用场景[0 （通用）1(聚合支付), 2（邻里优先）, 3（预订商场）]');
            $table->float('pre_payment_amount')->default(0)->comment('单笔支付满额领取');
            $table->unsignedTinyInteger('loop')->default(0)->comment('周期（天）');
            $table->unsignedTinyInteger('loop_order_num')->default(0)->comment('周期内购买多少单');
            $table->unsignedTinyInteger('loop_order_amount')->default(0)->comment('周期内消费总额');
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
        Schema::drop('card_conditions');
    }
}
