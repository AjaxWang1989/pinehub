<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatTemplateMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wechat_template_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_id')->comment('模版消息id');
            $table->string('app_id')->comment('微信 app id');
            $table->text('content')->comment('消息模版内容');
            $table->string('primary_industry')->comment('模板所属行业的一级行业');
            $table->string('deputy_industry')->comment('模板所属行业的二级行业');
            $table->string('title')->comment('模板标题');
            $table->timestamps();
            $table->index('template_id');
            $table->index('app_id');
            $table->index('primary_industry');
            $table->index('deputy_industry');
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
        Schema::drop('wechat_template_messages');
    }
}
