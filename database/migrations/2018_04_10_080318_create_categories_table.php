<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon')->default(null)->comment('图标');
            $table->string('name')->unique()->comment('分类名称');
            $table->unsignedInteger('parent_id')->default(null)->comment('分类父级');
            $table->string('app')->comment('程序类型');
            $table->timestamps();
            $table->softDeletes();
            $table->index('app');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
