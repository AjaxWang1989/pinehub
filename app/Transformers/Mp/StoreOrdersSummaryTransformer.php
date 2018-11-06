<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 17:37
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\OrderItem;
use App\Entities\Order;


class StoreOrdersSummaryTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return [
            'id'      => $model->id,
            'code'    => $model->code,
            'status'  => $model->status,
            'receiver_name'    => $model->receiverName,
            'card_id' => $model->cardId,
            'sell_point' => '',
            'reduce_cost'  => $model->tickets() ? $model->tickets['card_info']['base_info']['title'] : null,
            'receiver_address' => json_decode($model->receiverAddress)->receiver_address,
            'build_num'        => json_decode($model->receiverAddress)->build_num,
            'room_num'         => json_decode($model->receiverAddress)->room_num,
            'receiver_mobile'  => $model->receiverMobile,
            'total_amount'     => $model->totalAmount,
            'payment_amount'   => $model->paymentAmount,
            'created_at'       => $model->createdAt->format('Y-m-d H:i:s'),
            'order_item_merchandises' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data  = $orderItem->only(['name','sell_price','quality','total_amount']);
                return $data;
            }) : null,
        ];
    }
}