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
            'merchandise_id'=>$model->merchandise_id,
            'name'=>$model->merchandise->name,
            'main_image' => $model->merchandise->mainImage,
            'quality'=>$model->quality,
            'sell_price'=>round($model->sell_price,2),
            'amount' => $model->amount,
        ];
    }
}