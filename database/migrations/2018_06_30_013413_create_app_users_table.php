<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->comment('系统应用id');
            $table->unsignedInteger('user_id')->nullable()->default(null)->comment('用户id');
            //$table->unsignedInteger('wechat_user_id')->nullable()->default(null)->comment('微信用户信息表id');
            $table->tinyInteger('status')->default(1)->comment('状态：0-冻结账号，1-激活 2-待激活');
            $table->timestamps();
            $table->index('app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
