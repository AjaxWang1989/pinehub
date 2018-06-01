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

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $router = $this->app->make('app.routes')->router();
        $request = $router->getCurrentRequest();
        if (!empty($request)) {
           $appId = $request->input('app_id', null);
        }
        $wechatConfig = app(WechatConfigRepositoryEloquent::class);
        $this->app->singleton('wechat', function () {
           return new WechatService();
        });
    }
}