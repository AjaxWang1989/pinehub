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
        $currentWechat = app('current_wechat');
        $officeAccountConfig = config('wechat.office_account.default');
        $openPlatformConfig = config('wechat.open_platform.default');
        $miniProgramConfig = config('wechat.mini_program.default');
        $currentConfig = $currentWechat->only(['app_id', 'app_secret', 'token', 'aes_key']);
        if ($currentWechat) {
            switch ($currentWechat->type){
                case WECHAT_OFFICE_ACCOUNT:{
                    $officeAccountConfig = array_merge($officeAccountConfig, $currentConfig);
                    break;
                }
                case WECHAT_OPEN_PLATFORM:{
                    $openPlatformConfig = array_merge($openPlatformConfig, $currentConfig);
                    break;
                }
                case WECHAT_MINI_PROGRAM:{
                    $miniProgramConfig = array_merge($openPlatformConfig, $currentConfig);
                    break;
                }
            }
        }
        $config = [
            'office_account' => $officeAccountConfig,
            'open_platform'  => $openPlatformConfig,
            'mini_program'   => $miniProgramConfig,
            'payment'        => config('wechat.payment.default')
        ];
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
            return new WechatConfig();
        });
    }
}