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
            $table->string('code', 16)->comment('订单编号');
            $table->string('card_id', 32)->unique()->comment('卡券id');
            $table->string('wechat_app_id', 32)->nullable()->default(null)->comment('微信app id');
            $table->string('ali_app_id', 32)->nullable()->default(null)->comment('支付宝app id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统app id');
            $table->string('card_type', 16)->default(MEMBER_CARD)->comment('卡券类型');
            $table->json('card_info')->default(null)->comment('卡券信息');
            $table->unsignedTinyInteger('status')->default(false)->comment('0-审核中 1-审核通过 2-审核未通过');
            $table->tinyInteger('sync')->default(0)->comment('-1 不需要同步 0 - 同步失败 1-同步中 2-同步成功');
            $table->timestamp('begin_at')->nullable()->default(null)->comment('开始日期');
            $table->timestamp('end_at')->nullable()->default(null)->comment('结束时间');
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
