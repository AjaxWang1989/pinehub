<?php

namespace App\Providers;

use App\Entities\WechatConfig;
use App\Repositories\WechatConfigRepositoryEloquent;
use App\Services\AppManager;
use App\Services\Wechat\WechatService;
use Illuminate\Support\Facades\Log;
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
        $currentOfficialAccount = app('current_official_account');
        $currentMiniProgram = app('current_mini_program');
        $officialAccountConfig = config('wechat.official_account.default');
        $openPlatformConfig = config('wechat.open_platform.default');
        $miniProgramConfig = config('wechat.mini_program.default');
        $officialAccountConfig = array_merge($officialAccountConfig,  $currentOfficialAccount ?
            $currentOfficialAccount->only(['app_id', 'app_secret', 'token', 'aes_key']) : []);
        $miniProgramConfig = array_merge($miniProgramConfig, $currentMiniProgram ?
            $currentMiniProgram->only(['app_id', 'app_secret', 'token', 'aes_key']) : []);
        $config = [
            'official_account' => $officialAccountConfig,
            'open_platform'  => $openPlatformConfig,
            'mini_program'   => $miniProgramConfig,
            'payment'        => config('wechat.payment.default')
        ];
        $this->app->make('wechat')->setConfig($config);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('wechat', function (Application $app) {
            return new WechatService([
                'official_account' => [],
                'open_platform'  => [],
                'mini_program'   => [],
                'payment'        => config('wechat.payment.default')
            ], $app->make(AppManager::class));
        });

        $this->app->singleton('current_official_account', function(Application $app) {
            return $app->make(AppManager::class)->officialAccount;
        });

        $this->app->singleton('current_mini_program', function(Application $app) {
            return $app->make(AppManager::class)->miniProgram;
        });
    }
}