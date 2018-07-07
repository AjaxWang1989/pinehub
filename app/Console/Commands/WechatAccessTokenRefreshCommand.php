<?php

namespace App\Console\Commands;

use App\Entities\WechatConfig;
use Illuminate\Console\Command;

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
        WechatConfig::chunk('');
    }
}
