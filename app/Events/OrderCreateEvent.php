<?php
/**
 * OrderCreateEvent.php
 * User: katherine
 * Date: 19-5-19 下午7:13
 */

namespace App\Events;

use App\Entities\Order;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreateEvent extends Event implements ShouldQueue
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}