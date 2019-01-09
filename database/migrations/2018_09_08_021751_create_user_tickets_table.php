<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id', 32)->comment('优惠券id');
            $table->string('card_code', 32)->comment('优惠券编码');
            $table->unsignedInteger('user_id')->comment('会员id');
            $table->unsignedTinyInteger('status')->default(0)->comment('0-不可用，1-可用，2-已使用，3-过期');
            $table->timestamp('begin_at')->default(null)->comment('开始时间');
            $table->timestamp('end_at')->default(null)->comment('结束时间');
            $table->timestamps();
            $table->index('card_id');
            $table->index('card_code');
            $table->index('user_id');
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
        Schema::dropIfExists('user_tickets');
    }
}
