<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/24
 * Time: 2:05 PM
 */

namespace App\Transformers\Merchant;


use App\Entities\Shop;
use League\Fractal\TransformerAbstract;

class ShopTransformer extends TransformerAbstract
{
    public function transform(Shop $shop) {
        return $shop->toArray();
    }
}