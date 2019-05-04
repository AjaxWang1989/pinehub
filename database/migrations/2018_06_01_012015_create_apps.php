<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('apps', function (Blueprint $table) {
            $table->string('id', 16)->primary()->comment('app id');
            $table->unsignedInteger('owner_user_id')->nullable()->default(null)->comment('应用拥有者');
            $table->string('secret', 32)->comment('应用secret');
            $table->string('name', 16)->comment('应用名称');
            $table->string('logo')->comment('应用logo');
            $table->string('contact_name')->default('')->comment('联系人名称');
            $table->string('contact_phone_num', 12)->default('')->comment('联系电话');
            $table->string('wechat_app_id', 32)->nullable()->default(null)->comment('微信公众号appid');
            $table->string('mini_app_id', 32)->nullable()->default(null)->comment('小程序appid');
            $table->string('open_app_id', 32)->nullable()->default(null)->comment('api创建open platform appid');
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
        Schema::drop('apps');
    }
}
