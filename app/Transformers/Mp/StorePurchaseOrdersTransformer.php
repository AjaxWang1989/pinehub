<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 17:29
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\StorePurchaseOrders;


class StorePurchaseOrdersTransformer extends TransformerAbstract
{
    public function transform(StorePurchaseOrders $model){
        return [
            'code' => $model->code,
            'paid_at' => $model->paidAt->format('Y-m-d H:i:s'),
            'type' => $model->type,
            'status' => $model->status,
            'payment_amount' => $model->paymentAmount
        ];
    }
}