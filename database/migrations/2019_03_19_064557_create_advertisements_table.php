<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 20)->comment('banner标题');
            $table->string('app_id', 16)->comment('系统app id');
            $table->string('wechat_app_id', 32)->comment('微信app id');
            $table->string('banner_url')->comment('banner图片');
            $table->string('card_id')->nullable()->default(null)->comment('广告关联卡券');
            $table->json('conditions')->nullable()->default(null)
                ->comment('广告投放条件 sex payment_amount age');
            $table->timestamp('begin_at')->nullable()->default(null)->comment('开始时间');
            $table->timestamp('end_at')->nullable()->default(null)->comment('结束时间');
            $table->unsignedTinyInteger('status')->default(0)->comment('广告投放状态 0->未投放 1->投放中 2->下架');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `advertisements` comment'广告投放表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
