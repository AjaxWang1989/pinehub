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
        if(!$this->shop) {
            $data['shop_id'] = $data['shop']['id'];
            unset($data['shop']);
        }else{
            $this->shop['payment_amount'] = number_format($this->shop['payment_amount'], 2);
            $this->shop['ali_payment_amount'] = number_format($this->shop['ali_payment_amount'], 2);
            $this->shop['wechat_payment_amount'] = number_format($this->shop['wechat_payment_amount'], 2);
            $data['shop'] = $this->shop;
        }
        return $data;
    }
}