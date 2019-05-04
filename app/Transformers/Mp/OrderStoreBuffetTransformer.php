<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 18:13
 */

namespace App\Transformers\Mp;
use App\Entities\Shop;
use App\Entities\Merchandise;
use App\Entities\OrderItem;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class OrderStoreBuffetTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        $receiverAddress = json_encode($model->receiverAddress, true);
        return [
            'id'      => $model->id,
            'code'    => $model->code,
            'write_code'     => buildUrl('api.mp','/confirm/order/{id}', ['id' => $model->id]),
            'status'  => $model->status,
            'receiver_name'    => $model->receiverName,
            'receiver_address' => is_array($receiverAddress) ? $receiverAddress['receiver_address'] : $model->receiverAddress,
            'build_num'        => is_array($receiverAddress) ? $receiverAddress['build_num'] : null,
            'room_num'         => is_array($receiverAddress) ? $receiverAddress['room_num'] : null ,
            'receiver_mobile'  => $model->receiverMobile,
            'total_amount'     => round($model->totalAmount,2),
            'payment_amount'   => round($model->paymentAmount,2),
            'shop_start_hour'  => $model->shop->startAt,
            'shop_end_hour'    => $model->shop->endAt,
            'created_at'       => $model->createdAt->format('Y-m-d H:i:s'),
            'order_item_merchandises' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data  = $orderItem->only(['name','sell_price','quality','total_amount']);
                $data['sell_price'] = number_format($data['sell_price'], 2);
                return $data;
            }) : null,
        ];
    }
}