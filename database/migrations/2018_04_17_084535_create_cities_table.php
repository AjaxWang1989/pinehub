<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('国家ID');
            $table->unsignedInteger('province_id')->comment('省份ID');
            $table->string('code', 6)->comment('城市编码');
            $table->string('name')->comment('城市名称');
            $table->timestamps();
            $table->index('code');
            $table->index('country_id');
            $table->index('province_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
