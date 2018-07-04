<?php

namespace App\Transformers;

use App\Entities\OrderItem;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;

/**
 * Class OrderTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    /**
     * Transform the Order entity.
     *
     * @param \App\Entities\Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'order_item' => $model->orderItems ? $model->orderItems->map(function (OrderItem $orderItem) {
                $data = $orderItem->orderMerchandise ? $orderItem->orderMerchandise->only(['name', 'merchandise_id', 'sku_product_id', 'main_image', 'sell_price', 'quality',
                    'origin_price', 'cost_price']) : [];
                $data  = array_merge($data, $orderItem->only(['code', 'total_amount', 'payment_amount', 'discount_amount', 'signed_at',
                    'consigned_at', 'status']));
                $data['shop'] = $orderItem->shop->only(['id', 'name']);
                $data['merchandise_stock_num'] = $orderItem->orderMerchandise && $orderItem->orderMerchandise->merchandise ?
                    $orderItem->orderMerchandise->merchandise->stockNum : 0;
                $data['sku_product_stock_num'] = $orderItem->orderMerchandise && $orderItem->orderMerchandise->skuProduct ?
                    $orderItem->orderMerchandise->skuProduct->stockNum : 0;
                return $data;
            }) : null,
            'code' => $model->code,
            'buyer' => $model->buyer->only(['id', 'nickname', 'mobile']),
            'total_amount' => $model->totalAmount,
            'payment_amount' => $model->paymentAmount,
            'discount_amount' => $model->discountAmount,
            'paid_at' => $model->paidAt,
            'pay_type' => $model->payType,
            'status' => $model->status,
            'cancellation' => $model->cancellation,
            'signed_at' => $model->signedAt,
            'consigned_at' => $model->consignedAt,
            'post_no' => $model->postNo,
            'post_code' => $model->postCode,
            'post_name' => $model->postName,
            'receiver_city' => $model->receiverCity,
            'receiver_district' => $model->receiverDistrict,
            'receiver_address' => $model->receiverAddress,
            'type' => $model->type,
            'transaction_id' => $model->transactionId,

            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
