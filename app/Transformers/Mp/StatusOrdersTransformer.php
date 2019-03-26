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
    public function transform(Order $model)
    {
        $receiverAddress = json_decode($model->receiverAddress, true);
        return [
            'id' => $model->id,
            'code' => $model->code,
            'type' => $model->type,
            'pick_up_method' => $model->pickUpMethod,
            'status' => $model->status,
            'receiver_name' => $model->receiverName,
            'receiver_address' => is_array($receiverAddress) ? $receiverAddress['receiver_address'] : $model->receiverAddress,
            'build_num' => is_array($receiverAddress) ? $receiverAddress['build_num'] : null,
            'room_num' => is_array($receiverAddress) ? $receiverAddress['room_num'] : null,
            'receiver_mobile' => $model->receiverMobile,
            'quantity' => $model->merchandiseNum,
            'total_amount' => round($model->totalAmount, 2),
            'payment_amount' => round($model->paymentAmount, 2),
            'shop_end_hour' => isset($model->shop->endAt) ? $model->shop->endAt : null,
            'created_at' => $model->createdAt->format('Y-m-d H:i:s'),
            'paid_at' => $model->paidAt ? $model->paidAt->format('Y-m-d H:i:s'): null,
            'order_item_merchandises' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data = $orderItem->only(['merchandise_name', 'sell_price', 'quality', 'total_amount', 'main_image']);
                $data['sell_price'] = number_format($data['sell_price'], 2);
                return $data;
            }) : null,
        ];
    }
}