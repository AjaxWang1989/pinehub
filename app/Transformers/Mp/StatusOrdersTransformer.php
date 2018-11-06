<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 15:45
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\OrderItem;
use App\Entities\Order;


class StatusOrdersTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return [
            'id'      => $model->id,
            'code'    => $model->code,
            'status'  => $model->status,
            'receiver_name'    => $model->receiverName,
            'receiver_address' => isset(json_decode($model->receiverAddress)->receiver_address) ?json_decode($model->receiverAddress)->receiver_address : $model->receiverAddress ,
            'build_num'        => isset(json_decode($model->receiverAddress)->build_num) ? json_decode($model->receiverAddress)->build_num : null,
            'room_num'         => isset(json_decode($model->receiverAddress)->room_num) ? json_decode($model->receiverAddress)->room_num : null,
            'receiver_mobile'  => $model->receiverMobile,
            'quality'          => $model->merchandiseNum,
            'total_amount'     => $model->totalAmount,
            'payment_amount'   => $model->paymentAmount,
            'shop_end_hour'    => $model->shop->end_at,
            'created_at'       => $model->createdAt,
            'order_item_merchandises' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data  = $orderItem->only(['name','sell_price','quality','total_amount','main_image']);
                return $data;
            }) : null,
        ];
    }
}