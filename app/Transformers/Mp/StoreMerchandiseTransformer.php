<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 11:23
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ShopMerchandise;


class StoreMerchandiseTransformer extends TransformerAbstract
{
    public function transform(ShopMerchandise $model){
        return [
            'id'=> $model->merchandise->id,
            'merchandise_id' => $model->merchandise->id,
            'name'=> $model->merchandise->name,
            'main_image'=> $model->merchandise->mainImage,
            'origin_price' => round($model->merchandise->originPrice,2),
            'sell_price' => round($model->merchandise->sellPrice,2),
            'stock_num' => $model->stockNum,
            'sell_num' => $model->sellNum,
        ];
    }
}