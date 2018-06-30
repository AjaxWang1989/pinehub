<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mac')->nullable()->comment('访问者mac地址');
            $table->unsignedInteger('ip')->nullable()->comment('访问者ip地址');
            $table->string('os', 32)->nullable()->comment('访问者使用的操作系统');
            $table->string('brand', 64)->nullable()->comment('终端品牌');
            $table->string('position_hash', 16)->nullable()->default(null)->comment('位置编码');
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->point('position')->nullable()->comment('访问者所在经纬度');
            $table->string('app_id', 16)->nullable()->default(null)->comment('系统app id');
            $table->timestamps();
            $table->softDeletes();
            $table->index('os');
            $table->index('brand');
            $table->index('user_id');
            $table->index('app_id');
            $table->index('position_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
