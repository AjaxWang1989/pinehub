<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedBackMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_back_message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable()->default(null)->comment('用户id');
            $table->string('open_id', 64)->nullable()->default(null)->comment('微信open id或支付宝user ID');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统appid');
            $table->string('comment', 255)->nullable()->default(null)->comment('反馈内容');
            $table->string('mobile', 11)->nullable()->default(null)->comment('电话');
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
        Schema::dropIfExists('feed_back_message');
    }
}
