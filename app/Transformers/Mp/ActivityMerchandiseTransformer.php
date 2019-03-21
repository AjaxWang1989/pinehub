<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/19
 * Time: 20:55
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ActivityMerchandise;


class ActivityMerchandiseTransformer extends TransformerAbstract
{
    public function transform(ActivityMerchandise $model){
        return [
            'id'=>$model->id,
            'merchandise_id'=>$model->merchandiseId,
            'name' => $model->merchandise->name,
            'sell_price' => round($model->merchandise->sellPrice,2),
            'origin_price' => round($model->merchandise->originPrice,2),
            'stock_num' => $model->stockNum,
            'sell_num' => $model->sellNum,
            'tags' => isset($model->tags) ? $model->tags : [] ,
            'describe' => $model->describe,
            'main_image' => $model->mainImage ? $model->mainImage : $model->merchandise->mainImage,
        ];
    }
}