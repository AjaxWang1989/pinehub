<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAutoReplyMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wechat_auto_reply_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 32)->comment('微信app ID');
            $table->string('name', 16)->nullable()->default(null)->comment('规则名称');
            $table->boolean('focus_reply')->default(null)->comment('关注回复');
            $table->enum('type', [WECHAT_TEXT_MESSAGE, WECHAT_IMAGE_MESSAGE, WECHAT_VIDEO_MESSAGE, WECHAT_NEWS_MESSAGE,
                WECHAT_VOICE_MESSAGE])->default(WECHAT_TEXT_MESSAGE)->comment('类型');
            $table->json('prefect_match_keywords')->nullable()->comment('全匹配关键字数组');
            $table->json('semi_match_keywords')->nullable()->comment('半匹配关键字数组');
            $table->string('content', 64000)->comment('回复消息内容');
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
        //
        Schema::drop('wechat_auto_reply_messages');
    }
}
