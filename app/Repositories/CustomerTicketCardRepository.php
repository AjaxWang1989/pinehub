<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CustomerTicketCardRepository.
 *
 * @package namespace App\Repositories;
 */
interface CustomerTicketCardRepository extends RepositoryInterface
{
    /**
     * @param int $status
     * @param int $userId
     * @param string $shoppingCartAmount
     * @return mixed
     */
    public function userTickets(int $status,int $userId,string $shoppingCartAmount);
}
