<?php

namespace App\Transformers;

use App\Entities\Order;
use App\Repositories\OrderRepository;
use App\Repositories\ShopMerchandiseRepository;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;
use App\Entities\Shop as ShopItem;
use Illuminate\Database\Eloquent\Builder;
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
            'manager'  => $model->shopManager->only(['user_name', 'mobile', 'nickname', 'real_name']),
            'total_amount' => $model->totalAmount,
            'today_amount' => $model->todayAmount,
            'status' => $model->status,
            'sell_amount' => $model->sellAmount ? $model->sellAmount : 0,
            'order_count' => $model->ordersCount,
            'merchandise_num' => $model->shopMerchandisesCount,
            'this_month_amount' => $model->thisMonthAmount ? $model->thisMonthAmount : 0,
            'last_month_amount' => $model->lastMonthAmount ? $model->lastMonthAmount : 0,
            'balance' => $model->balance,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
