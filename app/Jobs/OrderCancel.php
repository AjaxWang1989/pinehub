<?php

namespace App\Jobs;

use App\Entities\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class OrderCancel extends Job implements ShouldQueue
{
    use SerializesModels;
    /**
     * @var Order
     * */
    protected $order = null;
    /**
     * Create a new job instance.
     * @param OrderRepository $repository
     * @param int $id
     * @return void
     */
    public function __construct(OrderRepository $repository, int $id)
    {
        //
        $this->order = $repository->find($id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if($this->order->status === Order::WECHAT_PAY || $this->order->status === Order::PAY_FAILED) {
            $this->order->status = Order::CANCEL;
            $this->order->save();
        }
    }
}
