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
            $table->string('card_id')->comment('卡券id');
            $table->string('app_id')->comment('微信或者支付宝app id');
            $table->enum('card_type', [MEMBER_CARD, COUPON_CARD, DISCOUNT_CARD,
                GROUPON_CARD])->default(MEMBER_CARD)->comment('卡券类型');
            $table->string('platform')->default('')->comment('适用平台');
            $table->timestamps();
            $table->softDeletes();
            $table->index('card_id');
            $table->index('app_id');
            $table->index('card_type');
        });

        Schema::create('card_extends', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
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
