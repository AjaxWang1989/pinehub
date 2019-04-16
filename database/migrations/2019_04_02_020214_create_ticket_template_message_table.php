<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTemplateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_template_messages', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id')->comment('卡券ID')->nullable();
            $table->unsignedInteger('user_template_id')->comment('自定义模版消息ID');
            $table->enum('scene', [TEMPLATE_TICKET_EXPIRE, TEMPLATE_TICKET_BOOK])->comment('模板消息具体场景');
            $table->unsignedTinyInteger('type')->default(TEMPLATE_UNDEFINED)->comment('模版类型');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_template_messages');
    }
}
