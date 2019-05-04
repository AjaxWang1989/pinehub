<?php

namespace App\Console\Commands;

use App\Entities\WechatConfig;
use App\Events\WechatAuthAccessTokenRefreshEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class WechatAccessTokenRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat.access.token:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh the wechat access token';

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
        WechatConfig::where('authorizer_access_token_expires_in', '<=', Carbon::now())->chunk(100, function (Collection $collection) {
            $collection->map(function (WechatConfig $wechatConfig) {
                Event::fire((new WechatAuthAccessTokenRefreshEvent($wechatConfig)));
            });
        });
        Log::debug( "end handle wechat access token refresh command \n");
    }
}
