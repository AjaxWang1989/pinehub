<?php

namespace App\Transformers;

use App\Entities\OrderItem;
use App\Entities\Merchandise;
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
        return array(
            'id'         => (int) $model->id,
            'transaction_id' => $model->transactionId,
            'order_items' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data = $orderItem->merchandise ? with($orderItem->merchandise, function (Merchandise $merchandise) {
                        $data['merchandise'] = $merchandise->only(['name', 'merchandise_id', 'sku_product_id', 'main_image', 'sell_price', 'quality']);
                        return $data;
                    }) : [];

                $data  = array_merge($data, $orderItem->only(array('code', 'total_amount', 'payment_amount',
                    'discount_amount', 'status')));

                /** @var array $data */

                $data['shop'] =$orderItem->shop ? $orderItem->shop->only(array('id', 'name')) : null;

                return $data;
            }) : null,

            'code' => $model->code,

            'customer' => $model->customer ? $model->customer->only(array('id', 'nickname', 'mobile')) : null,

            'member'   => $model->member ? $model->member->only(array('id', 'nickname', 'user_name', 'mobile')) : null,

            'payment_amount' => $model->paymentAmount,

            'total_amount' => $model->totalAmount,

            'discount_amount' => $model->discountAmount,

            'paid_at' => $model->paidAt,

            'pay_type' => $model->payType,

            'status' => $model->status,

            'type' => $model->type,

            'trade_status' => $model->tradeStatus,

            /* place your other model properties here */

            'created_at' => $model->createdAt,

            'updated_at' => $model->updatedAt
        );
    }
}
