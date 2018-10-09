<?php

namespace App\Transformers;

use App\Entities\OrderItem;
use App\Entities\OrderItemMerchandise;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;

/**
 * Class OrderItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderItemTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderItem entity.
     *
     * @param \App\Entities\Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'transaction_id' => $model->transactionId,
            'order_items' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data = $orderItem->orderMerchandise ?
                    with($orderItem->orderMerchandise, function (OrderItemMerchandise $merchandise){
                        $data = $merchandise->only(['name', 'merchandise_id', 'sku_product_id',
                            'main_image', 'sell_price', 'quality']);
                        $data['sell_price'] = number_format($data['sell_price'], 2);
//                        $data['origin_price'] = number_format($data['origin_price'], 2);
//                        $data['cost_price'] = number_format($data['cost_price'], 2);
                        return $data;
                    }) : [];

                $data  = array_merge($data, $orderItem->only(['code', 'total_amount', 'payment_amount', 'discount_amount', 'status']));
                $data['total_amount'] = number_format($data['total_amount'], 2);
                $data['payment_amount'] = number_format($data['payment_amount'], 2);
                $data['discount_amount'] = number_format($data['discount_amount'], 2);
                $data['shop'] =$orderItem->shop ? $orderItem->shop->only(['id', 'name']) : null;
                return $data;
            }) : null,
            'code' => $model->code,
            'customer' => $model->customer ? $model->customer->only(['id', 'nickname', 'mobile']) : null,
            'member'   => $model->member ? $model->member->only(['id', 'nickname', 'user_name', 'mobile']) : null,
            'payment_amount' => number_format($model->paymentAmount, 2),
            'paid_at' => $model->paidAt,
            'pay_type' => $model->payType,
            'status' => $model->status,
            'type' => $model->type,
            'trade_status' => $model->tradeStatus,

            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
