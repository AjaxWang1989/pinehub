<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAliUsersTable.
 */
class CreateAliUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ali_users', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->default(null)->comment('用户id');
            $table->string('app_id', 16)->comment('系统appid');
            $table->string('open_id', 64)->comment('支付宝user_id');
            $table->string('avatar')->nullable()->default(null)->comment('头像');
            $table->string('province', 16)->nullable()->default(null)->comment('省份');
            $table->string('city', 16)->nullable()->default(null)->comment('城市');
            $table->string('nickname', 32)->nullable()->default(null)->comment('用户昵称');
            $table->boolean('is_student_certified')->default(0)->comment('是否是学生');
            $table->tinyInteger('user_type')->default(2)->comment('用户类型（1/2） 1代表公司账户2代表个人账户');
            $table->char('user_status', 1)->default('T')->comment('用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
            B代表被冻结账户 W代表已注册，未激活的账户');
            $table->char('is_certified', 1)->default('T')->comment('是否通过实名认证。T是通过 F是没有实名认证。');
            $table->char('gender', 1)->default('M')->comment('【注意】只有is_certified为T的时候才有意义，否则不保证准确性.
             性别（F：女性；M：男性）。');
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
		Schema::drop('ali_users');
	}
}
