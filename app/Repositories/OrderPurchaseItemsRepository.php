<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:27
 */

namespace App\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderPurchaseItemsRepository extends RepositoryInterface
{
    /**
     * @param int $order_id
     * @param int $shop_id
     * @return mixed
     */
    public function orderPurchaseItems(int $order_id,int $shop_id);
}