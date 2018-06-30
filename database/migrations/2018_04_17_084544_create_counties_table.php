<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('国家ID');
            $table->unsignedInteger('province_id')->comment('省份ID');
            $table->unsignedInteger('city_id')->comment('城市ID');
            $table->string('code', 6)->comment('区县编码');
            $table->string('name', 16)->comment('区县名称');
            $table->timestamps();
            $table->index('code');
            $table->index('country_id');
            $table->index('province_id');
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}
