<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id')->comment('卡券card id');
            $table->string('card_code', 12)->comment('核销码');
            $table->string('app_id', 16)->comment('应用id');
            $table->boolean('is_give_by_friend')->default(false)->comment('是否朋友赠送');
            $table->string('friend_open_id', 64)->nullable()->default(null)->comment('好友微信open id');
            $table->unsignedInteger('user_id')->nullable()->default(null)->comment('用户id');
            $table->unsignedInteger('bonus')->default(0)->comment('会员积分');
            $table->float('balance')->default(0)->comment('会员卡余额');
            $table->string('open_id', 64)->nullable()->default(null)->comment('微信open id');
            $table->string('union_id', 64)->nullable()->default(null)->comment('微信open id');
            $table->string('outer_str')->nullable()->default(null)->comment('领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。');
            $table->boolean('active')->default(false)->comment('是否激活');
            $table->timestamps();
            $table->index('app_id');
            $table->index('card_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_cards');
    }
}
