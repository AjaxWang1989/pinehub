<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/8
 * Time: 15:54
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Merchandise;


class ReserveSearchMerchandisesTransformer extends TransformerAbstract
{
    public function transform(Merchandise $model){
        return [
            'id'=>$model->id,
            'name'=>$model->name,
            'main_image'=> $model->mainImage,
            'origin_price' => $model->originPrice,
            'sell_price' => $model->sellPrice,
            'stock_num' => $model->stockNum,
            'sell_num' => $model->sellNum,
        ];
    }
}