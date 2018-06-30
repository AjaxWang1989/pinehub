<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id', 16)->comment('系统应用appid');
            $table->unsignedTinyInteger('score')->comment('增加的积分数');
            $table->unsignedInteger('total_score')->comment('累计积分数');
            $table->tinyInteger('type')->default(0)->comment('类型 0-通用规则 1-特殊规则');
            $table->timestamp('expires_at')->default(null)->comment('过去日期，null表示永远有效');
            $table->boolean('notice_user')->default(false)->comment('是否给用户发送积分通知');
            $table->json('rule')->default(null)->comment('积分自定义规则：{"focus": true, "order_count": 100, "order_amount"" 1000, "merchandise":null}');
            $table->timestamps();
            $table->index('app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_rules');
    }
}
