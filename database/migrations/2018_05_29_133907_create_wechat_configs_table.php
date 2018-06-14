<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWechatConfigsTable.
 */
class CreateWechatConfigsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_configs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 18)->comment('微信公众好app ID');
            $table->string('app_secret', 32)->comment('微信公众号secret');
            $table->string('app_name', 255)->comment('微信公众号或者小程序名称');
            $table->string('token', 32)->nullable()->default(null)->comment('微信token');
            $table->string('aes_key', 43)->nullable()->default(null)->comment('微信EncodingAESKey');
            $table->string('type', 21)->default(WECHAT_OFFICIAL_ACCOUNT)->comment('OFFICE_ACCOUNT 公众平台， 
            OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序');
            $table->string('mode', 9)->default(WECHAT_EDITOR_MODE)->comment('公众号模式');
            $table->string('wechat_bind_app', 64)->nullable()->default(null)->comment('微信公众号绑定的应用程序或者小程序绑定的应用');
            $table->timestamps();
            $table->index('app_id');
            $table->index('wechat_bind_app');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wechat_configs');
	}
}
