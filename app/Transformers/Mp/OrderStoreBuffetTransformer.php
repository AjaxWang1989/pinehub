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
        return [
            'id'=>$model->id,
            'code' => $model->code,
            'status' => $model->status,
            'receiver_name'=>$model->receiverName,
            'receiver_address'=>$model->receiverAddress,
            'receiver_mobile'=>$model->receiverMobile,
            'total_amount' => $model->totalAmount,
            'pay_amount'  => $model->totalAmount,
            'comment' => $model->comment,
            'order_item_merchandises' => $model->orderItems,
        ];
    }
}