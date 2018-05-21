<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('code', 24)->comment('订单编号');
            $table->unsignedInteger('buyer_user_id')->nullable()->default(null)->comment('买家');
            $table->float('total_amount')->default(0)->comment('应付款');
            $table->float('payment_amount')->default('0')->comment('实际付款');
            $table->float('discount_amount')->default(0)->comment('优惠价格');
            $table->timestamp('paid_at')->nullable()->default(null)->comment('支付时间');
            $table->enum('pay_type', ['WECHAT_PAY', 'ALI_PAY'])->default('WECHAT_PAY')
                ->comment('支付方式默认微信支付');
            $table->unsignedInteger('status')->default(10)
                ->comment('订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成 ');
            $table->unsignedTinyInteger('cancellation')->default(0)
                ->comment('取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消 ');
            $table->timestamp('signed_at')->nullable()->default(null)->comment('签收时间');
            $table->string('receiver_city')->nullable()->default(null)->comment('收货城市');
            $table->string('receiver_district')->nullable()->default(null)->comment('收货人所在城市区县');
            $table->string('receiver_address')->nullable()->default(null)->comment('收货地址');
            $table->timestamp('consigned_at')->nullable()->default(null)->comment('发货时间');
            $table->unsignedTinyInteger('type')->default(0)->comment('订单类型：0-线下扫码 1-预定自提 2-商城订单');
            $table->unsignedTinyInteger('post_type')->default(0)->comment('0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运 ');
            $table->timestamps();
            $table->softDeletes();
            $table->index('code');
            $table->index('buyer_user_id');
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
