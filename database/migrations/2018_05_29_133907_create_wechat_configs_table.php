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
            $table->string('app_id')->comment('微信公众好app ID');
            $table->string('app_secret')->comment('微信公众号secret');
            $table->string('token')->nullable()->default(null)->comment('微信token');
            $table->string('aes_key')->nullable()->default(null)->comment('微信EncodingAESKey');
            $table->string('type')->default('OFFICE_ACCOUNT')->comment('OFFICE_ACCOUNT 公众平台， 
            OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序');
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
		Schema::drop('wechat_configs');
	}
}
