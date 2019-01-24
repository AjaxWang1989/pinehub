<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/24
 * Time: 2:05 PM
 */

namespace App\Transformers\Merchant;


use App\Entities\ShopManager;
use League\Fractal\TransformerAbstract;

class ShopManagerTransformer extends TransformerAbstract
{
    protected $shop = null;
    public function __construct($shop = null)
    {
        $this->shop = $shop;
    }

    public function transform(ShopManager $shopManager) {
        $data = $shopManager->toArray();
        if($this->shop) {
            $data['shop'] = $this->shop;
        }
        return $data;
    }
}