<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 16)->comment('名称');
            $table->string('app_id', 16)->comment('系统应用id');
            $table->string('type', 16)->comment('支付活动方式：满减送 PAY_FULL/支付礼包 PAY_GIFT');
            $table->timestamp('begin_at')->comment('开始时间');
            $table->timestamp('end_at')->comment('结束时间');
            $table->tinyInteger('status')->default(0)->comment('状态：0-未开始 1-进行中 2-结束 3-失效');
            $table->json('gift')->comment('礼包json：{discount:0.9, cost: 10.00, ticket_id: XXX, score: 10, condition: { least_amount: 100}}');
            $table->timestamps();
            $table->index('app_id');
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
