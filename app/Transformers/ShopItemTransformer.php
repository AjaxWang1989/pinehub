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
            'order_count' =>count(app()->make(OrderRepository::class)->findWhere(['shop_id'=>$model->id])),
            'sell_amount' => app()->make(OrderRepository::class)->findWhere(['shop_id'=>$model->id])->sum('payment_amount'),
            'merchandise_num' => count(app()->make(ShopMerchandiseRepository::class)->findWhere(['shop_id'=>$model->id])),
            'this_month_amount' => DB::table('orders')->where('shop_id',$model->id)
                ->where('paid_at','>=',date('Y-m-d 00:00:00', strtotime(date('Y-m', time()) . '-01 00:00:00')))
                ->where('paid_at','<=',date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 00:00:00')))
                ->get()->sum('payment_amount'),
            'last_month_amount' => DB::table('orders')->where('shop_id',$model->id)
                ->where('paid_at','>=' ,date('Y-m-d 00:00:00', strtotime('-1 month', strtotime(date('Y-m', time()) . '-01 00:00:00'))))
                ->where('paid_at','<=' ,date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-01 00:00:00') - 86400))
                ->get()->sum('payment_amount'),
            'balance' => $model->balance,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
