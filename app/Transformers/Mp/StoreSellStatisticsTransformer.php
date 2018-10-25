<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/15
 * Time: 22:25
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\OrderItemMerchandise;

class StoreSellStatisticsTransformer extends TransformerAbstract
{
    public function transform(OrderItemMerchandise $model)
    {
        return $model;
    }
}