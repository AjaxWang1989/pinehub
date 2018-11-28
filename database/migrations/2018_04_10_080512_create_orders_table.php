<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Order;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 16)->comment('订单编号');
            $table->string('open_id', 64)->nullable()->default(null)->comment('微信open id或支付宝user ID');
            $table->string('wechat_app_id', 32)->nullable()->default(null)->comment('维系app id');
            $table->string('ali_app_id', 32)->nullable()->default(null)->comment('支付宝app id');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统app id');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺id');
            $table->unsignedInteger('activity_id')->nullable()->default(null)->comment('新品活动id');
            $table->unsignedInteger('member_id')->nullable()->default(null)->comment('买家会员id');
            $table->string('card_id', 32)->default(null)->comment('优惠券id');
            $table->string('card_code', 32)->default(null)->comment('优惠券code');
            $table->unsignedInteger('customer_id')->nullable()->default(null)->comment('买家');
            $table->unsignedInteger('merchandise_num')->nullable()->default(null)->comment('此订单商品数量总数');
            $table->float('total_amount')->default(0)->comment('应付款');
            $table->float('payment_amount')->default('0')->comment('实际付款');
            $table->float('discount_amount')->default(0)->comment('优惠价格');
            $table->timestamp('paid_at')->nullable()->default(null)->comment('支付时间');
            $table->unsignedTinyInteger('pay_type')->default(Order::WECHAT_PAY)
                ->comment('支付方式默认微信支付:0-未知，1-支付宝，2-微信支付');
            $table->unsignedInteger('status')->default(10)
                ->comment('订单状态：0-订单取消 100-等待提交支付订单 200-提交支付订单 300-支付完成 400-已发货 500-订单完成 600-支付失败 ');
            $table->unsignedTinyInteger('cancellation')->default(0)
                ->comment('取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消 ');
            $table->unsignedTinyInteger('send_batch')->default(0)->comment('配送批次');
            $table->timestamp('signed_at')->nullable()->default(null)->comment('签收时间');
            $table->string('receiver_city', 16)->nullable()->default(null)->comment('收货城市');
            $table->string('receiver_district', 16)->nullable()->default(null)->comment('收货人所在城市区县');
            $table->string('receiver_name', 16)->nullable()->default(null)->comment('收货姓名');
            $table->string('receiver_address', 100)->nullable()->default(null)->comment('收货地址');
            $table->string('receiver_mobile', 11)->nullable()->default(null)->comment('收货人电话');
            $table->timestamp('send_start_time')->nullable()->default(null)->comment('配送开始时间');
            $table->timestamp('send_end_time')->nullable()->default(null)->comment('配送结束时间');
            $table->string('comment', 255)->nullable()->default(null)->comment('备注');
            $table->timestamp('consigned_at')->nullable()->default(null)->comment('发货时间');
            $table->unsignedTinyInteger('type')->default(0)->comment('订单类型：0-线下扫码 1-商城订单 2-站点用户订单  3-商家进货订单');
            $table->unsignedTinyInteger('pick_up_method')->default(0)->comment('取货方式：0-不需要取货 1-送货上门 2-自提');
            $table->unsignedMediumInteger('post_type')->default(0)
                ->comment('0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运 ');
            $table->boolean('score_settle')->default(false)->comment('积分是否已经结算');
            $table->string('post_no', 32)->nullable()->default(null)->comment('快递编号');
            $table->string('post_code', 6)->nullable()->default(null)->comment('邮编');
            $table->string('post_name', 64)->nullable()->default(null)->comment('快递公司名称');
            $table->string('transaction_id', 32)->nullable()->default(null)->comment('支付交易流水');
            $table->string('ip', 15)->nullable()->default(null)->comment('支付终端ip地址');
            $table->string('trade_status', 16)->nullable()->default(Order::TRADE_FINISHED)->comment('交易状态:TRADE_WAIT 等待交易 TRADE_FAILED 交易失败 TRADE_SUCCESS 交易成功 
                TRADE_FINISHED 交易结束禁止退款操作 TRADE_CANCEL 交易关闭禁止继续支付');
            $table->unsignedSmallInteger('year')->nullable()->default(null)->comment('年');
            $table->unsignedTinyInteger('month')->nullable()->default(null)->comment('月');
            $table->unsignedTinyInteger('day')->nullable()->default(null)->comment('日');
            $table->unsignedTinyInteger('week')->nullable()->default(null)->comment('星期');
            $table->unsignedTinyInteger('hour')->nullable()->default(null)->comment('小时');
            $table->unsignedInteger('receiving_shop_id')->nullable()->default(null)->comment('收货店铺id');
            $table->timestamps();
            $table->softDeletes();
            $table->index('code');
            $table->index('card_id');
            $table->index('card_code');
            $table->index('customer_id');
            $table->index('post_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
