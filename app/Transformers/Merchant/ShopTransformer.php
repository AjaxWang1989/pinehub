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
    protected $refreshed = true;
    public function __construct($refreshed = true)
    {
        $this->refreshed = $refreshed;
    }

    public function transform(Shop $shop) {
        return $this->refreshed ? $shop->toArray() : [];
    }
}