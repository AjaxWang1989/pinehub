<?php /** @noinspection PhpUndefinedClassInspection */

/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/28
 * Time: 下午5:24
 */

namespace App\Services;


use App\Entities\Order;
use App\Repositories\OrderRepositoryEloquent;
use Carbon\Carbon;
use Payment\Notify\PayNotifyInterface;

class PaymentNotify implements PayNotifyInterface
{
    protected $order = null;

    public function __construct(OrderRepositoryEloquent $model)
    {
        $this->order = $model;
    }

    public function notifyProcess(array $data)
    {
        // TODO: Implement notifyProcess() method.
        $order = $this->order->findWhere(['code' => $data['order_no']])->first();
        $order->status = Order::PAID;
        $order->paidAt = Carbon::now();
        $this->offLinePayOrder($order);
        tap($order, function (Order $order){
            $result = $order->save();
            if($result) {
                //发送模版消息
                $data=[];
                if($order->type !== Order::OFF_LINE_PAY){
                    $data['signed_at'] = $order->signedAt;
                    $data['consigned_at'] = $order->consignedAt;
                }
                $data['status'] = $order->paidAt;
                $order->orderItems()->update($data);
            }
        });
    }

    protected function offLinePayOrder(Order &$order)
    {
        if($order->type !== Order::OFF_LINE_PAY)
            return;
        $now = Carbon::now();
        $order->signedAt = $now;
        $order->consignedAt = $now;
    }
}