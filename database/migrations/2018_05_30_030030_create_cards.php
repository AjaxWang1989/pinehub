<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id', 32)->comment('卡券id');
            $table->string('wechat_app_id', 32)->nullable()->default(null)->comment('微信app id');
            $table->string('ali_app_id', 32)->nullable()->default(null)->comment('支付宝app id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统app id');
            $table->enum('card_type', [MEMBER_CARD, COUPON_CARD, DISCOUNT_CARD,
                GROUPON_CARD])->default(MEMBER_CARD)->comment('卡券类型');
            $table->json('card_info')->default(null)->comment('卡券信息');
            $table->boolean('status')->default(false)->comment('0-审核中 1-审核通过 2-审核未通过');
            $table->timestamps();
            $table->softDeletes();
            $table->index('card_id');
            $table->index('wechat_app_id');
            $table->index('ali_app_id');
            $table->index('card_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('cards');
    }
}
