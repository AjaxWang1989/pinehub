<?php

namespace App\Transformers;

use App\Entities\OrderItem;
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
                    $orderItem->orderMerchandise->only(['name', 'merchandise_id', 'sku_product_id',
                        'main_image', 'sell_price', 'quality']) : [];
                $data  = array_merge($data, $orderItem->only(['code', 'total_amount', 'payment_amount', 'discount_amount', 'status']));
                $data['shop'] = $orderItem->shop->only(['id', 'name']);
                return $data;
            }) : null,
            'code' => $model->code,
            'customer' => $model->customer->only(['id', 'nickname', 'mobile']),
            'member'   => $model->customer->member ? $model->customer->member->only(['id', 'nickname', 'user_name', 'mobile']) : null,
            'payment_amount' => $model->paymentAmount,
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
