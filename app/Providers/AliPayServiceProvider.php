<?php

namespace App\Providers;

use App\Services\AliPay\AliPayService;
use Illuminate\Support\ServiceProvider;

class AliPayServiceProvider extends ServiceProvider
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
        $this->app->singleton('alipay', function () {
            return new AliPayService();
        });
    }
}
