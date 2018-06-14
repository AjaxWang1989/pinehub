<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('菜单名称');
            $table->string('icon')->nullable()->comment('图标');
            $table->string('route_name')->nullable()->comment('路由名称');
            $table->unsignedInteger('parent_id')->nullable()->comment('父级菜单');
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
        Schema::dropIfExists('admin_menus');
    }
}
