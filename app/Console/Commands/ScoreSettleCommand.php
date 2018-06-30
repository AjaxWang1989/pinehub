<?php

namespace App\Console\Commands;

use App\Entities\Order;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class ScoreSettleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'score:settle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'settle score to user';

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
     */
    public function handle()
    {
        //
        Order::whereScoreSettle(false)->chunk(100, function (Collection $orders) {
            $orders->map(function (Order $order) {
                $order;
            });
        });
    }

    protected function noticeUserScoreSettle()
    {

    }
}
