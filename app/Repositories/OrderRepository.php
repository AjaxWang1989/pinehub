<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    //
    public function pushCriteria($class);

    /**
     * @param $itemMerchandises
     * @return mixed
     */
    public function insertMerchandise($itemMerchandises);

    /**
     * @param $sendTime
     * @param $userId
     * @return mixed
     */
    public function storeBuffetOrders($sendTime,$userId);

    /**
     * @param $sendTime
     * @param $userId
     * @return mixed
     */
    public function storeSendOrders($sendTime,$userId);

    /**
     * @param $status
     * @param $userId
     * @return mixed
     */
    public function allOrders(string $status,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function storeOrdersSummary(array $request,int $userId);
}
