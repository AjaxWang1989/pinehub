<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 21:20
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\StorePurchaseOrders;


class StoreCodeOrderMerchandiseUpTransformer extends TransformerAbstract
{
    public function transform(StorePurchaseOrders $model){
        return [
            'code'=>$model->code,
            'status' => $model->status
        ];
    }
}