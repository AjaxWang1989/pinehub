<?php

namespace App\Console\Commands;

use App\Entities\Order;
use App\Jobs\OrderUpdateStatus;
use App\Repositories\OrderRepository;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class OrderUpdateStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws
     */
    public function handle()
    {
        //
        $nowDate = Carbon::now();
        Order::whereIn('status', [Order::WAIT, Order::MAKE_SURE, Order::PAY_FAILED])
            ->whereRaw("TIMESTAMPDIFF(SECOND, ?,'created_at') >= ?", [$nowDate, config('order.auto_cancel_time')])
            ->chunk(100, function (Collection $orders) {
                $orders->map(function (Order $order) {
                    $job = (new OrderUpdateStatus(app(OrderRepository::class), $order->id, Order::CANCEL))
                        ->delay(1);
                    dispatch($job);
                });
            });

        Order::whereIn('status', [Order::PAID, Order::SEND])
            ->whereRaw("TIMESTAMPDIFF(DAY, ?,'created_at') >= ?", [$nowDate, config('order.trade_finished_time')])
            ->chunk(100, function (Collection $orders) {
                $orders->map(function (Order $order) {
                    $job = (new OrderUpdateStatus(app(OrderRepository::class), $order->id, Order::COMPLETED))
                        ->delay(1);
                    dispatch($job);
                });
            });
    }
}
