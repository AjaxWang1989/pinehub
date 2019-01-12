<?php

namespace App\Jobs;

use App\Entities\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $this->order = $repository->find($id);
        }catch (\Exception $exception) {
            if ($exception instanceof ModelNotFoundException) {
                Log::error('order model not found!');
            }
        }
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
        if($this->order && ($this->order->status === Order::WAIT
            || $this->order->status === Order::PAY_FAILED
            || $this->order->status === Order::MAKE_SURE
            || $this->order->status === Order::SEND
            || $this->order->status === Order::PAID)) {
            Log::info('update order status');
            $this->order->status = $this->status;
            $this->order->save();
        }
    }
}
