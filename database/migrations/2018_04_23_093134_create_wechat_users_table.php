<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWechatUsersTable.
 */
class CreateWechatUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_users', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment('用户ID');
            $table->string('open_id')->comment('open id');
            $table->string('session_key')->comment('session key');
            $table->timestamp('expires_at')->comment('session 过期');
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
		Schema::drop('wechat_users');
	}
}
