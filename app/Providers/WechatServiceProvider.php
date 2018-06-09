<?php

namespace App\Providers;

use App\Entities\WechatConfig;
use App\Repositories\WechatConfigRepositoryEloquent;
use App\Services\Wechat\WechatService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

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
        $currentWechat = $this->app['current_wechat'];
        $config = config('wechat');
        if ($currentWechat) {
            $config = array_merge($config, $currentWechat->toArray());
        }
        $this->app->singleton('wechat', function () use($config){
            return new WechatService($config);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('current_wechat', function(Application $app) {
            $appId = Request::input('app_id');
            if($appId)
                return WechatConfig::whereAppId($appId)->first();
            $wechatBindApp = Request::input('bind_app');
            if($wechatBindApp)
                return WechatConfig::whereWechatBindApp($wechatBindApp)->first();
            return null;
        });
    }
}