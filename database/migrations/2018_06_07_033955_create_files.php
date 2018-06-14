<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('endpoint')->comment('云存储节点url，本地存储root');
            $table->string('bucket')->nullable()->default(null)->comment('云存储bucket或者本地存储路径');
            $table->string('driver')->comment('文件存储驱动');
            $table->string('path')->comment('文件路径');
            $table->boolean('encrypt')->default(false)->comment('是否加密');
            $table->string('encrypt_key')->nullable()->default(null)->comment('密钥');
            $table->string('encrypt_method')->nullable()->default(null)->comment('加密算法');
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
        //
        Schema::drop('files');
    }
}
