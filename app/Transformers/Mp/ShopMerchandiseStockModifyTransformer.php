<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 17:04
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ShopMerchandise;


class ShopMerchandiseStockModifyTransformer extends TransformerAbstract
{
    public function transform(ShopMerchandise $model){
        return [
            'id'=>$model->id,
            'stock_num'=>$model->stockNum,
        ];
    }
}