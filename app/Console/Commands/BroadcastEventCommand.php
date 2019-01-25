<?php

namespace App\Console\Commands;

use App\Events\OrderPaidNoticeEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BroadcastEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:event';

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
     */
    public function handle()
    {
        //
//        broadcast(new OrderPaidNoticeEvent(1));
//        publish('test', 'event1', 'test message');
        app('redis')->subscribe('test-channel', function () {
            Log::info('channel result sub');
        });
        $result = app('redis')->publish('test-channel', 'test message');
        Log::info('channel result ', [$result]);
    }
}
