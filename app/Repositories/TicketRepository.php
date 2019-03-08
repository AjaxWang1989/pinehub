<?php

namespace App\Repositories;


use App\Entities\Customer;
use App\Entities\Order;
use App\Entities\Ticket;

/**
 * Interface TicketRepository.
 *
 * @package namespace App\Repositories;
 */
interface TicketRepository extends CardRepository
{
    //
    public function getConditionalTickets(Order $order);

    public function receiveTicket(Customer $customer, Ticket $ticket);
}
