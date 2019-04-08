<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWxTemplateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_template_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_id', 16)->comment('模版消息id');
            $table->string('wx_app_id', 32)->comment('微信 app id');
            $table->string('title', 16)->comment('模板标题');
            $table->string('primary_industry')->comment('模板所属行业的一级行业');
            $table->string('deputy_industry')->comment('模板所属行业的二级行业');
            $table->text('content')->comment('消息模版内容');
            $table->json('items')->comment('模板消息中文关键字示例');
            $table->timestamps();

            $table->index('template_id');
            $table->index('wx_app_id');
            $table->index('primary_industry');
            $table->index('deputy_industry');
        });
        DB::statement('ALTER TABLE wx_template_messages AUTO_INCREMENT=11');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wx_template_messages');
    }
}
