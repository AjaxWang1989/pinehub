<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('apps', function (Blueprint $table) {
            $table->string('id')->primary()->comment('app id');
            $table->string('secret')->comment('应用secret');
            $table->string('name')->comment('应用名称');
            $table->string('logo')->comment('应用logo');
            $table->string('slug')->comment('系统标示');
            $table->timestamps();
            $table->softDeletes();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('apps');
    }
}
