<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Shop;

/**
 * Class ShopTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopTransformer extends TransformerAbstract
{
    /**
     * Transform the Shop entity.
     *
     * @param Shop $model
     *
     * @return array
     */
    public function transform(Shop $model)
    {
        return [
            'id'         => (int) $model->id,
            'code' => $model->code,
            'name'  => $model->name,
            /* place your other model properties here */
            'country' => $model->country->name,
            'country_id' => $model->countryId,
            'province' => $model->province->name,
            'province_id' => $model->provinceId,
            'city' => $model->city->name,
            'county' => $model->county->name,
            'city_id' => $model->cityId,
            'county_id' => $model->countyId,
            'address' => $model->address,
            'lat' => $model->position->getLat(),
            'lng' => $model->position->getLng(),
            'manager'  => $model->shopManager->only(['id', 'user_name', 'nickname', 'mobile', 'real_name']),
            'manager_name' => $model->shopManager->realName ? $model->shopManager->realName : $model->shopManager->nickname,
            'manager_mobile' => $model->shopManager->mobile,
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
            'payment_url' => apiUrlGenerator('api.backend', 'store.payment.code', ['storeId' => $model->id]),
            'status' => $model->status,
            'start_at' => $model->startAt,
            'end_at' => $model->endAt,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
