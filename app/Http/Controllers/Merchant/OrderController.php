<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/6/25
 * Time: 10:24 PM
 */

namespace App\Http\Controllers\Merchant;


use App\Entities\Order;
use App\Entities\ShopManager;
use Dingo\Api\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders()
    {
        /**@var ShopManager $manager**/
        $manager = Auth::user();
        $orders  = Order::whereShopId($manager->shop->id)
            ->where('paid_at', '>=', Carbon::now()->startOfDay())
            ->where('paid_at', '<', Carbon::now())
            ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED])
            ->orderBy('paid_at', 'desc')
            ->get();
        $count = $orders->count();
        $orders = $orders->map(function (Order $order) {
            return [
                'order_no' => $order->code,
                'pay_type' => $order->payTypeStr(),
                'pay_amount' => number_format($order->paymentAmount, 2),
                'paid_at' => $order->paidAt ? $order->paidAt->format('Y-m-d h:i:s')
                    : Carbon::now()->format('Y-m-d h:i:s')
            ];
        });
        $data = [
            'orders' => $orders->toArray(),
            'count' => $count
        ];
        /**@var Response $response**/
        return $this->response($data);
    }
}