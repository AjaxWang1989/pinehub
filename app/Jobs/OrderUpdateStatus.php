<?php

namespace App\Jobs;

use App\Entities\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderUpdateStatus extends Job implements ShouldQueue
{
    use SerializesModels;
    /**
     * @var Order
     * */
    protected $order = null;

    protected $status = null;
    /**
     * Create a new job instance.
     * @param OrderRepository $repository
     * @param int $id
     * @param int $status
     * @return void
     */
    public function __construct(OrderRepository $repository, int $id, int $status)
    {
        //
        $this->order = $repository->find($id);
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info('handle order update', $this->order->toArray());
        if($this->order->status === Order::WAIT
            || $this->order->status === Order::SEND
            || $this->order->status === Order::PAID) {
            Log::info('update order status');
            $this->order->status = $this->status;
            $this->order->save();
        }
    }
}
