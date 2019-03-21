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
     * @param string $status
     * @param int $userId
     * @param float $shoppingCartAmount
     * @return mixed
     */
    public function userTickets(string $status,int $userId, float $shoppingCartAmount = null);

    /**
     * @param int $userId
     * @param string $status
     * @return mixed
     */
    public function customerTicketCards (int $userId,string $status);
}
