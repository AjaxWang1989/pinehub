<?php

namespace App\Providers;

use App\Repositories\WechatConfigRepositoryEloquent;
use App\Services\Wechat\WechatService;
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
        $bindApp = isset($this->app['wechat_bind_app']) ? $this->app['wechat_bind_app'] : null;
        $config = config('wechat');
        if ($bindApp) {
            $wechatConfig = app(WechatConfigRepositoryEloquent::class);
            $wechatConfigData = $wechatConfig->findWhere(['wechat_bind_app' => $bindApp])->first();
            if ($wechatConfigData) {
                $config = array_merge($config, $wechatConfigData->toArray());
            }
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

    }
}