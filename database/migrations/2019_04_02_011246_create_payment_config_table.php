<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['ALI', 'WX', 'OTHER'])->default('ALI')->comment('支付类型');
            $table->boolean('need_send_template_message')->default(true)->comment('是否开启模版消息推送');
            $table->unsignedInteger('user_template_id')->default(0)->comment('用户模版消息');
            $table->json('configs')->nullable()->default(null)->comment('配置详情');
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
        Schema::dropIfExists('payment_configs');
    }
}
