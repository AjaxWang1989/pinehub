<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 15:45
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class StatusOrdersTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return [
            'id'=>$model->id,
            'code' => $model->code,
            'type' => $model->type,
            'merchandise_num' => $model->merchandiseNum,
            'payment_amount'=>$model->paymentAmount,
            'total_amount' => $model->totalAmount,
            'status' => $model->status,
            'receiver_address'=>$model->receiverAddress,
            'order_item_merchandises' => $model->orderItemMerchandises,
        ];
    }
}