<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/12/16
 * Time: 1:51 AM
 */

namespace App\Transformers\Mp;


use App\Entities\StoreShoppingCart;

class StoreShoppingCartTransformer extends TransformerAbstract
{
    public function transform(StoreShoppingCart $model){
        return [
            'id'=>$model->id,
            'name'=>$model->name,
            'shopping_carts'=> $model->shoppingCarts
        ];
    }
}