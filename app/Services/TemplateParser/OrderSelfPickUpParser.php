<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午4:48
 */

namespace App\Services\TemplateParser;

use App\Entities\Order;
use App\Entities\Shop;
use Carbon\Carbon;

class OrderSelfPickUpParser extends BaseParser
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // 自提码
    private function selfPickUpCode()
    {
        return $this->order->code;
    }

    private function address()
    {
        return $this->order->shop->address;
    }

    // 店铺营业时间
    private function pickUpTime()
    {
        /** @var Shop $shop */
        $shop = $this->order->shop;
        return Carbon::now()->addDay()->toDateString() . ' ' . $shop->startAt . '-' . $shop->endAt;
    }

    private function title()
    {
        $items = $this->order->orderItems;
        $title = '';
        foreach ($items as $item) {
            $title .= "{$item->merchandiseName} ";
        }
        $title = substr($title, 0, -1);
        return $title;
    }

    private function amount()
    {
        return $this->order->paymentAmount;
    }

    private function paidAt()
    {
        return $this->order->paidAt;
    }
}