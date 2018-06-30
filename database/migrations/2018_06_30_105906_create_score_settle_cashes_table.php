<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreSettleCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_settle_cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->nullable()->default(null)->comment('订单');
            $table->unsignedInteger('score_rule_id')->nullable()->default(null)->comment('积分规则id');
            $table->unsignedTinyInteger('score')->default(0)->comment('积分数');
            $table->unsignedTinyInteger('type')->default(1)->comment('规则类型：0 - 通用规则， 1 - 特殊规则');
            $table->string('score_rule_name', 32)->comment('积分规则名称');
            $table->unsignedInteger('user_id')->comment('被积分用户id');
            $table->boolean('settled');
            $table->timestamps();
            $table->index('settled');
            $table->index('score_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_settle_cashes');
    }
}
