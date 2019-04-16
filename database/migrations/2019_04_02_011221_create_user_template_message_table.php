<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserTemplateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_template_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wx_app_id', 32)->comment('微信ID');
//            $table->unsignedTinyInteger('type')->default(TEMPLATE_UNDEFINED)->comment('模版类型');
            $table->unsignedInteger('template_id')->comment('模版消息ID');
            $table->json('content')->comment('模版消息填充内容，参考微信文档');
            $table->unsignedTinyInteger('is_default')->comment('是否为默认模板')->default(0);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE user_template_messages AUTO_INCREMENT=11');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_template_messages');
    }
}
