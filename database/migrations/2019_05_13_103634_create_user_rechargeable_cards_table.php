<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRechargeableCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rechargeable_cards', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('rechargeable_card_id')->comment('卡种ID');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('amount')->comment('卡内余额，初始值为卡内设定余额，逾期不可用');
            $table->timestamp('invalid_at')->comment('卡种失效时间');
            $table->unsignedTinyInteger('is_auto_renew')->default(0)->comment('是否自动续费，默认否');
            $table->unsignedTinyInteger('status')->default(1)->comment('用户持有卡种状态 1=>有效 2=>失效');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rechargeable_cards');
    }
}
