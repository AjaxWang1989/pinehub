<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 18:45
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ShoppingCart;


class ShoppingCartTransformer extends TransformerAbstract
{
    public function transform(ShoppingCart $model){
        return [
            'id'=>$model->id,
            'merchandise_id'=>$model->merchandiseId,
            'name'=>$model->merchandise->name,
            'main_image' => $model->merchandise->mainImage,
            'quality'=>$model->quality,
            'sell_price'=>round($model->sellPrice,2),
            'amount' => $model->amount,
            'batch' => $model->batch,
            'date' => $model->date,
            'type' => $model->type
        ];
    }
}