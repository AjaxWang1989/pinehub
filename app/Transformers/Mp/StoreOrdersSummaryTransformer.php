<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 17:37
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class StoreOrdersSummaryTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return $model;
    }
}