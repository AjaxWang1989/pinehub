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
use Illuminate\Support\Facades\Log;
use Payment\Notify\PayNotifyInterface;

class PaymentNotify implements PayNotifyInterface
{
    protected $order = null;

    public function __construct(OrderRepositoryEloquent $model)
    {
        $this->order = $model;
    }

    /**
     * @param array $data
     * @return boolean
     * @throws \Exception
     */
    public function notifyProcess(array $data)
    {
        // TODO: Implement notifyProcess() method.
        Log::info('============wechat payment notify ============', $data);
        /** @var TYPE_NAME $exception */
        try {
            /** @var Order $order */
            $order = $this->order->findWhere(['code' => $data['order_no']])->first();
            $this->offLinePayOrder($order);
            $order->transactionId = $data['transaction_id'];
            if ($data['trade_state'] === 'success') {
                $order->tradeStatus = Order::TRADE_SUCCESS;
                $order->status = Order::PAID;
                $order->paidAt = Carbon::now();
                if ($order->type === Order::OFF_LINE_PAYMENT_ORDER) {
                    $order->status = Order::COMPLETED;
                    $order->pickUpMethod = Order::USER_SELF_PICK_UP;
                }
                if ($order->consumeRecord) {
                    $order->status = Order::COMPLETED;
                }
            } else {
                $order->status = Order::PAY_FAILED;
                $order->tradeStatus = Order::TRADE_FAILED;
            }
            tap($order, function (Order $order) use ($data) {
                $result = $order->save();
                if ($result) {
                    //发送模版消息
                    $orderData = [];
                    if ($order->type !== Order::OFF_LINE_PAYMENT_ORDER) {
                        $orderData['signed_at'] = $order->signedAt;
                        $orderData['consigned_at'] = $order->consignedAt;
                    }
                    $orderData['status'] = $order->status;
                    $order->orderItems()->update($orderData);
                }
            });
            return true;
        } catch (\Exception $exception) {
            Log::error('支付通知错误：', [$exception, $exception->getTraceAsString()]);
            return false;
        }

    }

    protected function offLinePayOrder(Order &$order)
    {
        if ($order->type !== Order::OFF_LINE_PAYMENT_ORDER)
            return;
        $now = Carbon::now();
        $order->signedAt = $now;
        $order->consignedAt = $now;
    }
}