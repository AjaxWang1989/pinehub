<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTicketCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_ticket_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id')->comment('卡券card id');
            $table->string('card_code', 12)->comment('核销码');
            $table->string('app_id', 16)->comment('应用id');
            $table->unsignedInteger('customer_id')->comment('客户id');
            $table->boolean('used')->default(false)->comment('是否核销');
            $table->timestamps();
            $table->index('app_id');
            $table->index('card_id');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_ticket_cards');
    }
}
