<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Shop as ShopItem;

/**
 * Class ShopItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopItemTransformer extends TransformerAbstract
{
    /**
     * Transform the ShopItem entity.
     *
     * @param ShopItem $model
     *
     * @return array
     */
    public function transform(ShopItem $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'code' => $model->code,
            'country' => $model->country->name,
            'province' => $model->province->name,
            'city' => $model->city->name,
            'county' => $model->county->name,
            'address' => $model->address,
            'manager'  => $model->shopManager->only(['user_name', 'mobile', 'nickname']),
            'total_amount' => $model->totalAmount,
            'today_amount' => $model->todayAmount,
            'status' => $model->status,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
