<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wechat_apps', function (Blueprint $table) {
            $table->string('wechat_app_id')->comment('微信应用');
            $table->string('app_slug')->comment('系统程序标示');
            $table->unique(['wechat_app_id', 'app_slug']);
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
        Schema::drop('wechat_apps');
    }
}
