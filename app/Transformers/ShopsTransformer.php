<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Shop;

/**
 * Class ShopsTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopsTransformer extends TransformerAbstract
{
    /**
     * Transform the Shops entity.
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
            'country' => $model->country->name,
            'province' => $model->province->name,
            'city' => $model->city->name,
            'county' => $model->county->name,
            'address' => $model->address,
            'manager'  => $model->shopManager->only(['id', 'user_name', 'nickname', 'mobile', 'real_name']),
            'description' => $model->description,
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
            'status' => $model->status,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
