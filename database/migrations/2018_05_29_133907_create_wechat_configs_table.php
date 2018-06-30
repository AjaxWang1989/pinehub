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
            $table->string('app_id', 28)->comment('微信app ID');
            $table->string('app_secret', 32)->comment('微信公众号secret');
            $table->string('app_name', 255)->comment('微信公众号或者小程序名称');
            $table->string('token', 32)->nullable()->default(null)->comment('微信token');
            $table->string('aes_key', 43)->nullable()->default(null)->comment('微信EncodingAESKey');
            $table->string('type', 32)->default(WECHAT_OFFICIAL_ACCOUNT)->comment('OFFICIAL_ACCOUNT 公众平台， 
            OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序');
            $table->string('mode', 9)->default(WECHAT_EDITOR_MODE)->comment('公众号模式');
            $table->string('wechat_bind_app')->nullable()->default(null)->comment('微信公众号绑定的应用程序或者小程序绑定的应用');
            $table->string('nickname')->nullable()->default(null)->comment('公众号或者小程序昵称');
            $table->string('head_img')->nullable()->default(null)->comment('微信公众号或者小程序头像');
            $table->string('user_name')->nullable()->default(null)->comment('授权方公众号的原始ID');
            $table->string('alias')->nullable()->default(null)->comment('授权方公众号所设置的微信号，可能为空');
            $table->string('principal_name')->nullable()->default(null)->comment('公众号的主体名称');
            $table->string('qrcode_url')->nullable()->default(null)->comment('二维码图片的URL，开发者最好自行也进行保存');
            $table->string('auth_code')->nullable()->default(null)->comment('');
            $table->timestamp('auth_code_expires_in')->nullable()->default(null)->comment('');
            $table->string('auth_info_type')->nullable()->default(null)->comment('');
            $table->string('component_access_token')->nullable()->default(null)->comment('第三方平台access_token');
            $table->timestamp('component_access_token_expires_in')->nullable()->default(null)->comment('有效期，为2小时');
            $table->string('authorizer_refresh_token')->nullable()->default(null)->comment('授权刷新令牌');
            $table->string('authorizer_access_token')->nullable()->default(null)->comment('授权令牌');
            $table->timestamp('authorizer_access_token_expires_in')->nullable()->default(null)->comment('授权令牌,有效期，为2小时');
            $table->json('service_type_info')->nullable()->default(null)->comment('授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号');
            $table->json('verify_type_info')->nullable()->default(null)->comment('授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，
            3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证');
            $table->json('business_info')->nullable()->default(null)->comment('用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门
            店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能');

            $table->json('func_info')->nullable()->default(null)->comment('公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限 
            2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 
            12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
            帐号类型和认证情况，来判断公众号的接口权限');

            $table->json('mini_program_info')->nullable()->default(null)->comment('可根据这个字段判断是否为小程序类型授权');
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
