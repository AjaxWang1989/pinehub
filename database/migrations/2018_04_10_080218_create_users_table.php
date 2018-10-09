<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->string('mobile', 11)->comment('用户手机号码');
            $table->string('user_name', 16)->unique()->comment('用户名称');
            $table->string('nickname', 16)->default(null)->comment('昵称');
            $table->string('real_name', 16)->default(null)->comment('真实姓名');
            $table->string('password', 255)->default(null)->comment('密码');
            $table->enum('sex', ['UNKNOWN', 'MALE', 'FEMALE'])->default('UNKNOWN')->comment('性别');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('city', 16)->nullable()->comment('城市');
            $table->string('province', 16)->nullable()->comment('省份');
            $table->string('country', 16)->nullable()->comment('国家');
            $table->unsignedInteger('can_use_score')->default(0)->comment('用户可用积分');
            $table->unsignedInteger('score')->default(0)->comment('用户积分');
            $table->unsignedInteger('total_score')->default(0)->comment('用户总积分');
            $table->unsignedInteger('vip_level')->default(0)->comment('VIP等级');
            $table->timestamp('last_login_at')->nullable()->comment('最后登录时间');
            $table->unsignedTinyInteger('status')->default(1)->comment('用户状态0-账户冻结 1-激活状态 2-等待授权');
            $table->unsignedInteger('order_count')->default(0)->comment('订单数');
            $table->unsignedTinyInteger('channel')->default(0)->comment('渠道来源 0-未知 1-微信 2-支付宝');
            $table->unsignedTinyInteger('register_channel')->default(0)->comment('注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP');
            $table->json('tags')->default(null)->comment('标签');
            $table->enum('mobile_company', ['CT', 'CU', 'CM'])->comment('手机号码所属公司');
            $table->timestamps();
            $table->softDeletes();
            $table->index('app_id');
            $table->index('sex');
            $table->index('city');
            $table->index('province');
            $table->index('country');
            $table->index('mobile_company');
            $table->unique(['app_id', 'mobile']);
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
