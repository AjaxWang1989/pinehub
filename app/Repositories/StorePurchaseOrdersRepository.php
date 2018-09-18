<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:19
 */

namespace App\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;


interface StorePurchaseOrdersRepository extends RepositoryInterface
{
    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function storePurchaseStatistics(array $request,int $userId);

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function storeOrders(array $request,int $userId);

}