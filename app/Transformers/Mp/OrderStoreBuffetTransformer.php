<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 18:13
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class OrderStoreBuffetTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return $model;
    }
}