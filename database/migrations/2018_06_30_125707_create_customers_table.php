<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统应用appid');
            $table->string('mobile', 11)->nullable()->default(null)->comment('手机号码');
            $table->unsignedInteger('member_id')->nullable()->default(null)->comment('会员id');
            $table->string('platform_app_id', 32)->nullable()->default(null)->comment('微信公众平台、小程序、开放app id');
            $table->string('type')->default('WECHAT_OFFICIAL_ACCOUNT')->comment('WECHAT_OFFICE_ACCOUNT 公众平台，
            WECHAT_OPEN_PLATFORM 微信开放平台 WECHAT_MINI_PROGRAM 微信小程序 ALIPAY_OPEN_PLATFORM  支付宝开发平台 SELF 平台客户');
            $table->string('union_id', 32)->nullable()->default(null)->comment('union id');
            $table->string('platform_open_id', 64)->comment('三方平台用户唯一标志');
            $table->string('session_key', 64)->nullable()->default(null)->comment('session key');
            $table->timestamp('session_key_expires_at')->default(null)->comment('session 过期');
            $table->string('avatar')->nullable()->default(null)->comment('头像');
            $table->string('country', 16)->nullable()->comment('国家');
            $table->string('province', 16)->nullable()->default(null)->comment('省份');
            $table->string('city', 16)->nullable()->default(null)->comment('城市');
            $table->string('nickname', 16)->nullable()->default(null)->comment('用户昵称');
            $table->enum('sex', ['UNKNOWN', 'MALE', 'FEMALE'])->default('UNKNOWN')->comment('性别');
            $table->json('privilege')->nullable()->comment('微信特权信息');
            $table->boolean('is_student_certified')->default(0)->comment('是否是学生');
            $table->tinyInteger('user_type')->default(2)->comment('用户类型（1/2） 1代表公司账户2代表个人账户');
            $table->char('user_status', 1)->default('T')->comment('用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
            B代表被冻结账户 W代表已注册，未激活的账户');
            $table->boolean('is_certified')->default(true)->comment('是否通过实名认证。T是通过 F是没有实名认证。');
            $table->unsignedInteger('can_use_score')->default(0)->comment('用户可用积分');
            $table->unsignedInteger('score')->default(0)->comment('用户积分');
            $table->unsignedInteger('total_score')->default(0)->comment('用户总积分');
            $table->unsignedInteger('order_count')->default(0)->comment('订单数');
            $table->unsignedTinyInteger('channel')->default(0)->comment('渠道来源 0-未知 1-微信 2-支付宝');
            $table->unsignedTinyInteger('register_channel')->default(0)->comment('注册渠道:0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP');
            $table->json('tags')->default(null)->comment('标签');
            $table->timestamps();
            $table->softDeletes();
            $table->index('app_id');
            $table->index('platform_app_id');
            $table->index('union_id');
            $table->index('platform_open_id');
            $table->index('sex');
            $table->unique(['app_id', 'type', 'platform_app_id', 'platform_open_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
