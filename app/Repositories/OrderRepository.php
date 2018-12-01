<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
     * 自提订单
     * @param string $date
     * @param int $batch
     * @param int $shopId
     * @return mixed
     */
    public function storeBuffetOrders(string $date, int $batch, int $shopId);

    /**
     * @param string $date
     * @param int $batch
     * @param int $shopId
     * @return mixed
     */
    public function storeSendOrders(string $date, int $batch,  int $shopId);

    /**
     * @param $status
     * @param $customerId
     * @return mixed
     */
    public function userOrders(string $status, int $customerId);

    /**
     * @param $status
     * @param $startAt
     * @param $endAt
     * @param int $shopId
     * @param $type
     * @return mixed
     */
    public function storeOrdersSummary($status, $startAt, $endAt, int $shopId, $type);

    /**
     * @param int $shopId
     * @param string $unit
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $limit
     * @return Collection
     */
    public function orderStatistics(int $shopId, string $unit, Carbon $startAt, Carbon $endAt, int $limit);

    /**
     *
     * @param Collection $orders
     * @param $count
     * @param $unit
     * @return array
     */
    public function buildOrderStatisticData(Collection $orders, $count, $unit);
}
