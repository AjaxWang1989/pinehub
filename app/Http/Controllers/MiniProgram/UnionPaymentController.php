<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/12/6
 * Time: 11:59 PM
 */

namespace App\Http\Controllers\MiniProgram;


use App\Entities\Order;

class UnionPaymentController extends Controller
{
    public function wxPay()
    {
        $mpUser = $this->mpUser();
        $order = new Order();
        $order->customerId = $mpUser->id;
        $order->memberId = $mpUser->memberId;
        $order->openId = $mpUser->platformOpenId;
        $order->appId = $mpUser->appId;
        $order->payType = Order::WECHAT_PAY;
    }

    public function aliPay()
    {

    }
}