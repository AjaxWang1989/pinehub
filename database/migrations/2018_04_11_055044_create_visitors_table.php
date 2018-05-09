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
            $table->string('mac')->nullable()->comment('访问者mac地址');
            $table->unsignedInteger('ip')->nullable()->comment('访问者ip地址');
            $table->string('os')->nullable()->comment('访问者使用的操作系统');
            $table->string('brand')->nullable()->comment('终端品牌');
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->point('position')->nullable()->comment('访问者所在经纬度');
            $table->timestamps();
            $table->softDeletes();
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
