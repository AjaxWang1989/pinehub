<?php

namespace App\Transformers;

use App\Entities\Shop;
use League\Fractal\TransformerAbstract;

/**
 * Class ShopDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the ShopDetail entity.
     *
     * @param \App\Entities\Shop $model
     *
     * @return array
     */
    public function transform(Shop $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'country' => $model->country->only(['id', 'code', 'name']),
            'province' => $model->province->only(['id', 'code', 'name']),
            'city' => $model->city->only(['id', 'name', 'code']),
            'county' => $model->county->only(['id', 'name', 'code']),
            'address' => $model->address,
            'manager'  => $model->shopManager->only(['id', 'user_name', 'nickname', 'mobile', 'real_name']),
            'total_amount' => $model->totalAmount,
            'today_amount' => $model->todayAmount,
            'total_off_line_amount' => $model->totalOffLineAmount,
            'today_off_line_amount' => $model->todayOffLineAmount,
            'total_ordering_amount' => $model->totalOrderingAmount,
            'today_ordering_amount' => $model->todayOrderingAmount,
            'total_order_write_off_amount' => $model->totalOrderWriteOffAmount,
            'today_order_write_off_amount' => $model->todayOrderWriteOffAmount,
            'total_ordering_num' => $model->totalOrderingNum,
            'today_ordering_num' => $model->todayOrderingNum,
            'total_order_write_off_num' => $model->totalOrderWriteOffNum,
            'today_order_write_off_num' => $model->todayOrderWriteOffNum,
            'position' => $model->position,
            'status' => $model->status,
            'orders' => $model->orders(),
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
