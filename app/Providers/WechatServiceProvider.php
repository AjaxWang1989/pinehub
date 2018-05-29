<?php

namespace App\Providers;

use App\Services\WechatService;
use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $wechatConfig = '';
        $config = config($wechatConfig);
        $this->app->singleton('wechat', function () {
           return new WechatService();
        });
    }
}
