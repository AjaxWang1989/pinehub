<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
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
            $table->string('app_id')->comment('app id');
            $table->string('name', 255)->nullable()->default(null)->comment('菜单名称');
            $table->boolean('is_public')->default(false)->comment('菜单是否发布');
            $table->json('menus')->comment('menus');
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
