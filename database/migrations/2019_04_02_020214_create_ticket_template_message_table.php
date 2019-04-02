<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('ticket_id')->comment('卡券ID');
            $table->unsignedInteger('user_template_id')->comment('自定义模版消息ID');
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
