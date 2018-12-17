<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:19
 */

namespace App\Repositories;
use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;


interface StorePurchaseOrdersRepository extends RepositoryInterface
{
    /**
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $toreId
     * @return mixed
     */
    public function storePurchaseStatistics(Carbon $startAt, Carbon $endAt,int $toreId);

    /**
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $storeId
     * @return mixed
     */
    public function storeOrders(Carbon $startAt, Carbon $endAt,int $storeId);

}