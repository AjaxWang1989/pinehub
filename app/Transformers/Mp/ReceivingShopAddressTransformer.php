<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 15:52
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Order;


class ReceivingShopAddressTransformer extends TransformerAbstract
{
    public function transform(Order $model){
        return [
            'shop_id'  => isset($model->receivingShopAddress->id) ? $model->receivingShopAddress->id : null,
            'name'     => isset($model->receivingShopAddress->name) ? $model->receivingShopAddress->name : null,
            'position' => isset($model->receivingShopAddress->position) ? $model->receivingShopAddress->position : null,
            'address'  => isset($model->receivingShopAddress->address) ? $model->receivingShopAddress->address : null
        ];
    }

}