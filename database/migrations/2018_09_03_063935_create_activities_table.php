<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id')->comment('项目应用ID');
            $table->unsignedInteger('shop_id')->nullable()->default(null)->comment('店铺id');
            $table->string('title', 16)->comment('活动名称');
            $table->string('poster_img')->comment('海报图片');
            $table->string('description', 1024)->default('')->comment('详情');
            $table->unsignedInteger('status')->default(10)->comment('0 未开始 1 进行中 2 已结束');
            $table->timestamp('start_at')->nullable()->default(null)->comment('活动开始时间');
            $table->timestamp('end_at')->nullable()->default(null)->comment('活动结束时间');
            $table->timestamps();
            $table->index('app_id');
            $table->index('shop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
