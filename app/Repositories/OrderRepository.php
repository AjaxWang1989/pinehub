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
    public function insertMerchandise( array $itemMerchandises);

    /**
     * @param $sendTime
     * @param $userId
     * @return mixed
     */
    public function storeBuffetOrders(array $sendTime,int $userId);

    /**
     * @param $sendTime
     * @param $userId
     * @return mixed
     */
    public function storeSendOrders(array $sendTime,int $userId);

    /**
     * @param $status
     * @param $userId
     * @return mixed
     */
    public function orders(string $status,int $customerId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function storeOrdersSummary(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed'
     */
    public function orderStatistics(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed'
     */
    public function bookPaymentAmount(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed'
     */
    public function sitePaymentAmount(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellOrderNum(array $request,int $userId);

    /**
     * @param array $request
     * @return mixed
     */
    public function todaySellAmount(array $request);

    /**
     * @param array $request
     * @return mixed
     */
    public function weekSellAmount(array $request);

    /**
     * @param array $request
     * @return mixed
     */
    public function sellAmount(array $request);

    /**
     * @param array $request
     * @return mixed
     */

    public function todayBuyNum(array $request);

    /**
     * @param array $request
     * @return mixed
     */
    public function weekBuyNum(array $request);

    /**
     * @param array $request
     * @return mixed
     */
    public function weekStatistics(array $request);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function orderDateHigh(array $request,int $userId);
}
