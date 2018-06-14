<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('国家ID');
            $table->string('code', 6)->comment('省份编码');
            $table->string('name')->comment('省份名称');
            $table->timestamps();
            $table->index('code');
            $table->index('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
