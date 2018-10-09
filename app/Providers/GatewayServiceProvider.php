<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/8/21
 * Time: 下午1:29
 */

namespace App\Providers;


use App\Services\Http\GateWayService;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton('api.gateways', function () {
            return new GateWayService(config('gateway.api_domain'), config('gateway.api'));
        });

        $this->app->singleton('web.gateways', function () {
            return new GateWayService(config('gateway.web_domain'), config('gateway.web'));
        });
    }
}