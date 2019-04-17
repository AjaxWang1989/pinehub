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
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // 自提码
    public function selfPickUpCode()
    {
        return $this->order->code;
    }

    public function address()
    {
        return $this->order->shop->address;
    }

    // 店铺营业时间
    public function pickUpTime()
    {
        /** @var Shop $shop */
        $shop = $this->order->shop;
        return Carbon::now()->addDay()->toDateString() . ' ' . $shop->startAt . '-' . $shop->endAt;
    }

    public function title()
    {
        $items = $this->order->orderItems;
        $title = '';
        foreach ($items as $item) {
            $title .= "{$item->merchandiseName} ";
        }
        $title = substr($title, 0, -1);
        return $title;
    }

    public function amount()
    {
        return $this->order->paymentAmount;
    }

    public function paidAt()
    {
        return $this->order->paidAt;
    }
}