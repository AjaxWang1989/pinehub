<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 11:27
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ShopMerchandise;


class StoreStockStatisticsTransformer extends TransformerAbstract
{
    public function transform(ShopMerchandise $model){
        return [
            'id'=> $model->merchandise->id,
            'name'=> $model->merchandise->name,
            'sell_price' => round($model->merchandise->sellPrice),
            'stock_num' => $model->stockNum,
            'code' => $model->shop->code,
        ];
    }
}