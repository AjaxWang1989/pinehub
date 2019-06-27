<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/24
 * Time: 2:05 PM
 */

namespace App\Transformers\Merchant;


use App\Entities\Shop;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class ShopTransformer extends TransformerAbstract
{
    protected $refreshed = true;
    public function __construct($refreshed = true)
    {
        $this->refreshed = $refreshed;
    }

    public function transform(Shop $shop) {
        $shop['payment_amount'] = number_format($shop['payment_amount'], 2);
        $shop['ali_payment_amount'] = number_format($shop['ali_payment_amount'], 2);
        $shop['wechat_payment_amount'] = number_format($shop['wechat_payment_amount'], 2);
        $data = $this->refreshed ? $shop->only([
            'buyer_num', 'order_num', 'need_send_order_num', 'self_pick_order_num',
            'payment_amount', 'ali_payment_amount', 'wechat_payment_amount', 'id', 'name'
        ]) : [];
        return $data;
    }
}