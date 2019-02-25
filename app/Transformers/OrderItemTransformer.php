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
        $orderItems = $model->orderItems->map(function (OrderItem $orderItem) {
            $data  = $orderItem->only(['code', 'total_amount', 'payment_amount', 'discount_amount', 'status', 'sell_price',
                'origin_price', 'merchandise_id', 'name', 'main_image', 'quality']);

            $data['shop'] =$orderItem->shop ? $orderItem->shop->only(array('id', 'name')) : null;

            return $data;
        });

        return array(
            'id'         => (int) $model->id,
            'transaction_id' => $model->transactionId,
            'order_items' => $orderItems,

            'code' => $model->code,

            'customer' => $model->customer ? $model->customer->only(array('id', 'nickname', 'mobile')) : null,

            'member'   => $model->member ? $model->member->only(array('id', 'nickname', 'user_name', 'mobile')) : null,

            'payment_amount' => $model->paymentAmount,

            'total_amount' => $model->totalAmount,

            'discount_amount' => $model->discountAmount,

            'paid_at' => $model->paidAt,

            'activity' => $model->activity,

            'pay_type' => $model->payType,

            'status' => $model->status,

            'type' => $model->type,

            'trade_status' => $model->tradeStatus,
            'receiving_shop' => $model->receivingShopAddress,

            /* place your other model properties here */

            'created_at' => $model->createdAt,

            'updated_at' => $model->updatedAt
        );
    }
}
