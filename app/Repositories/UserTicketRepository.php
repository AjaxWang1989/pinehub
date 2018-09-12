<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserTicketRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserTicketRepository extends RepositoryInterface
{
    //
    public function userTickets(int $status,int $userId);
}
