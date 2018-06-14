<?php

use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateShopsTable.
 */
class CreateShopsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function(Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->nullable()->comment('餐车编号');
            $table->unsignedInteger('user_id')->comment('店铺老板用户id');
            $table->unsignedInteger('country_id')->comment('国家id');
            $table->unsignedInteger('province_id')->comment('省份id');
            $table->unsignedInteger('city_id')->comment('城市id');
            $table->unsignedInteger('county_id')->comment('所属区县id');
            $table->string('address')->nullable()->comment('详细地址');
            $table->point('position')->nullable()->comment('店铺定位');
            $table->text('description')->nullable()->comment('店铺描述');
            $table->string('geo_hash')->nullable()->comment('位置hash编码');
            $table->float('total_amount', 12, 2)->default(0)->comment('店铺总计营业额');
            $table->float('today_amount', 12, 2)->default(0)->comment('今日营业额');

            $table->float('total_off_line_amount', 12, 2)->default(0)->comment('店铺预定总计营业额');
            $table->float('today_off_line_amount', 12, 2)->default(0)->comment('今日线下营业额');

            $table->float('total_ordering_amount', 12, 2)->default(0)->comment('店铺总计营业额');
            $table->float('today_ordering_amount', 12, 2)->default(0)->comment('今日预定营业额');

            $table->unsignedInteger('today_ordering_num')->default(0)->comment('今日预定订单数量');
            $table->unsignedInteger('total_ordering_num')->default(0)->comment('店铺自提系统一共预定单数');

            $table->unsignedInteger('today_order_write_off_amount')->default(0)->comment('今日核销订单营业额');
            $table->unsignedInteger('total_order_write_off_amount')->default(0)->comment('店铺自提系统一共核营业额');

            $table->unsignedInteger('today_order_write_off_num')->default(0)->comment('今日核销订单数量');
            $table->unsignedInteger('total_order_write_off_num')->default(0)->comment('店铺自提系统一共核销单数');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0-等待授权 1-营业中 2-休业 3-封锁店铺');
            $table->string('app')->nullable()->default(null)->comment('程序类型');
            $table->string('wechat_app_id')->nullable()->default(null)->comment('微信app ID');
            $table->string('ali_app_id')->nullable()->default(null)->comment('支付宝app ID');
            $table->string('mt_app_id')->nullable()->default(null)->comment('美团app id');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->index('city_id');
            $table->index('county_id');
            $table->index('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shops');
	}
}
