<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 16)->default('')->comment('素材名称');
            $table->string('introduction')->default('')->comment('素材介绍');
            $table->boolean('is_tmp')->default(false)->comment('是否临时素材');
            $table->string('media_id')->comment('素材id');
            $table->string('url')->default('')->comment('图片url');
            $table->string('type')->default('image')->comment('图片（image）: 2M，支持bmp/png/jpeg/jpg/gif格式;
            语音（voice）：2M，播放长度不超过60s，mp3/wma/wav/amr格式;视频（video）：10MB，支持MP4格式;缩略图（thumb）：64KB，支持JPG格式;图文（news）');
            $table->json('articles')->default(null)->comment('图文');
            $table->timestamp('expires_at')->default(null)->comment('临时素材过期时间');
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
        Schema::dropIfExists('wechat_materials');
    }
}
