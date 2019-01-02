<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 20:51
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return [
            'id'=>$model->id,
            'receiver_name'=>$model->receiverName,
            'receiver_address'=>$model->receiverAddress,
            'receiver_mobile'=>$model->receiverMobile,
            'type' => $model->type,
            'pay_type' => $model->payType,
            'customer' => $model->customer->only(['nickname', 'avatar', 'mobile', 'platform_open_id']),
            'payment_amount' => $model->paymentAmount,
            'total_amount' => $model->totalAmount,
            'paid_time' => $model->paidAt ? $model->paidAt->format('Y-m-d') : null
        ];
    }
}