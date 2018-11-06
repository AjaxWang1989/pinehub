<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTicketCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_ticket_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id', 32)->default('')->comment('卡券id');
            $table->string('card_code', 12)->comment('核销码');
            $table->string('app_id', 16)->comment('应用id');
            $table->boolean('is_give_by_friend')->default(false)->comment('是否朋友赠送');
            $table->string('friend_open_id', 64)->nullable()->default(null)->comment('好友微信open id');
            $table->unsignedInteger('customer_id')->comment('客户id');
            $table->string('open_id', 64)->nullable()->default(null)->comment('微信open id');
            $table->string('union_id', 64)->nullable()->default(null)->comment('微信open id');
            $table->string('outer_str')->nullable()->default(null)->comment('领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。');
            $table->boolean('active')->default(false)->comment('是否激活');
            $table->unsignedTinyInteger('status')->default(0)->comment('0-不可用，1-可用，2-已使用，3-过期');
            $table->timestamps();
            $table->index('app_id');
            $table->index('customer_id');
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
        Schema::dropIfExists('customer_ticket_cards');
    }
}
