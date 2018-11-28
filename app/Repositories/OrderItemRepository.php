<?php

namespace App\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderItemRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderItemRepository extends RepositoryInterface
{

    /**
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return mixed
     */
    public function sellMerchandiseNum(int $shopId, Carbon $startAt, Carbon $endAt);

    /**
     * 消费排名
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $limit
     * @return mixed
     */
    public function consumptionRanking(int $shopId, Carbon $startAt, Carbon $endAt, int $limit = 5);


    /**
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $limit
     * @return mixed
     */
    public function merchandiseSalesRanking(int $shopId, Carbon $startAt, Carbon $endAt, int $limit = 5);

}
