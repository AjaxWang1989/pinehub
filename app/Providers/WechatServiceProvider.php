<?php

namespace App\Providers;

use App\Repositories\WechatConfigRepositoryEloquent;
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
        $router = $this->app->make('app.routes')->router();
        $request = $router->getCurrentRequest();
        $appId = $request->route('app_id');
        if(empty($appId)) {
            $appId = $request->input('app_id');
        }
        $wechat = app(WechatConfigRepositoryEloquent::class)->first();
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