<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id')->comment('活动ID');
            $table->string('type', 16)->comment('支付活动方式：满减送 PAY_FULL/支付礼包 PAY_GIFT');
            $table->unsignedInteger('ticket_id')->nullable()->default(null)->comment('优惠券id');
            $table->float('discount')->default(0)->comment('折扣');
            $table->float('cost')->default(0)->comment('抵用金额');
            $table->float('least_amount')->default(0)->comment('最低消费');
            $table->unsignedInteger('score')->default(0)->comment('积分');
            $table->timestamps();
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_gifts');
    }
}
