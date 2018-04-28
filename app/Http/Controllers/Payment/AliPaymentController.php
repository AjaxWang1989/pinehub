<?php

namespace App\Http\Controllers\Payment;

use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Payment\PaymentController as Controller;
use Payment\ChargeContext;

class AliPaymentController extends Controller
{
    /**
     * 聚合支付
     * @param Request $request
     * @return Response| null
     * @throws
     * */
    public function aggregate(Request $request)
    {
        $order = $this->orderModel->create([]);
        return $this->preOrder(self::WAP_PAY, $order->id);
    }

    /**
     * 统一下单
     * @param int $id
     * @param string $type
     * @param ChargeContext|null $charge
     * @return Response| null
     * */
    public function preOrder(string $type, int $id, $charge = null)
    {
        $charge = app('payment.ali.'.$type);
        return parent::preOrder($type, $id, $charge);
    }

    protected function notifyCallback()
    {
        parent::notifyCallback(); // TODO: Change the autogenerated stub
    }
}
