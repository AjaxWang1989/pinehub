<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wechat_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', [VIEW_BUTTON, CLICK_BUTTON, MP_BUTTON])->default(CLICK_BUTTON)->comment('	菜单的响应动作类型，view表示网页类型，click表示点击类型，miniprogram表示小程序类型');
            $table->string('name', 60)->comment('菜单标题，不超过16个字节，子菜单不超过60个字节');
            $table->string('key', 128)->nullable()->default(null)->comment('	菜单KEY值，用于消息接口推送，不超过128字节');
            $table->string('url', 1024)->nullable()->default(null)->comment('网页 链接，用户点击菜单可打开链接，不超过1024字节。
            type为miniprogram时，不支持小程序的老版本客户端将打开本url');
            $table->string('media_id')->nullable()->default(null)->comment('调用新增永久素材接口返回的合法media_id');
            $table->string('appid')->nullable()->default(null)->comment('小程序的appid（仅认证公众号可配置）');
            $table->string('page_path')->nullable()->default(null)->comment('小程序的页面路径');
            $table->unsignedInteger('parent_id')->nullable()->default(null)->comment('父类id');
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
        Schema::drop('wechat_menus');
    }
}
