<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 11)->unique()->comment('用户手机号码');
            $table->string('user_name')->unique()->comment('用户名称');
            $table->string('nickname')->default(null)->comment('昵称');
            $table->string('real_name')->default(null)->comment('真实姓名');
            $table->string('password')->default(null)->comment('密码');
            $table->enum('sex', ['UNKNOWN', 'MALE', 'FEMALE'])->default('UNKNOWN')->comment('性别');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('city')->nullable()->comment('城市');
            $table->string('province')->nullable()->comment('省份');
            $table->string('country')->nullable()->comment('国家');
            $table->unsignedInteger('vip_level')->default(0)->comment('VIP等级');
            $table->timestamp('last_login_at')->nullable()->comment('最后登录时间');
            $table->unsignedTinyInteger('status')->default(1)->comment('用户状态0-账户冻结 1-激活状态 2-等待授权');
            $table->enum('mobile_company', ['CT', 'CU', 'CM'])->comment('手机号码所属公司');
            $table->timestamps();
            $table->softDeletes();
            $table->index('mobile');
            $table->index('sex');
            $table->index('city');
            $table->index('province');
            $table->index('country');
            $table->index('mobile_company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
