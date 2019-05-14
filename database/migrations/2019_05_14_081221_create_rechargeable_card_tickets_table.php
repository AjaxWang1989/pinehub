<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechargeableCardTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechargeable_card_tickets', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('rechargeable_card_id')->comment('储蓄卡/折扣卡/卡种ID');
            $table->unsignedInteger('ticket_id')->comment('优惠券ID');

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rechargeable_card_tickets');
    }
}
