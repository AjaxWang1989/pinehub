<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 11:06
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\ShopMerchandise;


class StoreCategoriesTransformer extends TransformerAbstract
{
    public function transform(ShopMerchandise $model){
        return [
            'id'=>$model->category->id,
            'name'=>$model->category->name,
        ];
    }
}