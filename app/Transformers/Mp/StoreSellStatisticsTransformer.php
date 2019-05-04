<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/15
 * Time: 22:25
 */

namespace App\Transformers\Mp;
use App\Entities\Order;
use League\Fractal\TransformerAbstract;

class StoreSellStatisticsTransformer extends TransformerAbstract
{
    public function transform(Order $model)
    {
        return $model;
    }
}