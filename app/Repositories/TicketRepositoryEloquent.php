<?php

namespace App\Repositories;

use App\Entities\Ticket;

/**
 * Class TicketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketRepositoryEloquent extends CardRepositoryEloquent implements TicketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ticket::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
//        Ticket::creating(function (Ticket &$ticket) {
//            if($ticket->ticketType)
//                $ticket->cardType = $ticket->ticketType;
//            if($ticket->ticketInfo)
//                $ticket->cardInfo = $ticket->ticketInfo;
//            unset($ticket->ticketType, $ticket->ticketType);
//        });
    }
    
}
