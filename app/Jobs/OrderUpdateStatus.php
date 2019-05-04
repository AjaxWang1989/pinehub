<?php

namespace App\Jobs;

use App\Entities\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * @property  $id
 */
class OrderUpdateStatus extends Job implements ShouldQueue
{
    use SerializesModels;

    protected $status = null;

    protected $id = null;
    /**
     * Create a new job instance.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function __construct(int $id, int $status)
    {
        //
        try {
            $this->id = $id;
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
        /** @var Order $order */
        $order = app(OrderRepository::class)->find($this->id);
        if($order) {
            switch ($this->status) {
                case Order::CANCEL: {
                    if ($order->status === Order::WAIT
                        || $order->status === Order::PAY_FAILED
                        || $order->status === Order::MAKE_SURE) {
                        $order->status = Order::CANCEL;
                        $order->save();
                    }
                    break;
                }
                case Order::COMPLETED: {
                    if ($order->status === Order::SEND
                        || $order->status === Order::PAID) {
                        $order->status = Order::COMPLETED;
                        $order->save();
                    }
                    break;
                }
            }
        }
    }
}
