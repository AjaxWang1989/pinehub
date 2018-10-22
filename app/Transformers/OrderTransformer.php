<?php

namespace App\Transformers;

use App\Entities\OrderItem;
use App\Entities\Merchandise;
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
                $data = $orderItem->merchandise ?
                    with($orderItem->merchandise, function (Merchandise $merchandise){
                        $data = $merchandise->only(['name', 'merchandise_id', 'sku_product_id',
                            'main_image', 'sell_price', 'quality','origin_price','cost_price']);
                        $data['sell_price'] = number_format($data['sell_price'], 2);
                        $data['origin_price'] = number_format($data['origin_price'], 2);
                        $data['cost_price'] = number_format($data['cost_price'], 2);
                        return $data;
                    }) : [];
                $data  = array_merge($data, $orderItem->only(['code', 'total_amount', 'payment_amount', 'discount_amount', 'signed_at',
                    'consigned_at', 'status']));
                $data['total_amount'] = number_format($data['total_amount'], 2);
                $data['payment_amount'] = number_format($data['payment_amount'], 2);
                $data['discount_amount'] = number_format($data['discount_amount'], 2);
                $data['shop'] = $orderItem->shop ? $orderItem->shop->only(['id', 'name']) : null;
                $data['merchandise_stock_num'] = $orderItem->merchandise && $orderItem->merchandise ?
                    $orderItem->merchandise->stockNum : 0;
                $data['sku_product_stock_num'] = $orderItem->merchandise && $orderItem->merchandise->skuProduct ?
                    $orderItem->merchandise->skuProduct->stockNum : 0;
                return $data;
            }) : null,
            'code' => $model->code,
            'customer' => $model->customer ? $model->customer->only(['id', 'nickname', 'mobile']) : null,
            'member'   => $model->member ? $model->member->only(['id', 'nickname', 'user_name', 'mobile']) : null,
            'total_amount' => number_format($model->totalAmount, 2),
            'payment_amount' => number_format($model->paymentAmount, 2),
            'discount_amount' => number_format($model->discountAmount, 2),
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
            'trade_status' => $model->tradeStatus,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
