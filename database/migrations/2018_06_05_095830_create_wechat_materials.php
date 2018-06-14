<?php

use Illuminate\Support\Facades\Schema;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wechat_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id')->comment('微信app id');
            $table->boolean('is_temp')->comment('是否临时素材');
            $table->enum('type', [WECHAT_VOICE_MESSAGE, WECHAT_NEWS_MESSAGE, WECHAT_VIDEO_MESSAGE, WECHAT_IMAGE_MESSAGE])
                ->default(WECHAT_IMAGE_MESSAGE)->comment('素材类型');
            $table->json('content')->comment('素材内容');
            $table->timestamps();
            $table->index('is_temp');
            $table->index('type');
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
        Schema::drop('wechat_materials');
    }
}
