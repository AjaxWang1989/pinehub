<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/23
 * Time: 上午9:37
 */

namespace App\Providers;


use App\Repositories\OrderRepositoryEloquent;
use App\Services\PaymentNotify;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Payment\ChargeContext;
use Payment\Config;
use Payment\NotifyContext;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('payment.ali.wap', function (){
            $chargeContext = new ChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_CHANNEL_WAP, $config);
            return $chargeContext;
        });
        $this->app->singleton('payment.ali.web', function (){
            $chargeContext = new ChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_CHANNEL_WEB, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.ali.bar', function (){
            $chargeContext = new ChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_CHANNEL_BAR, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.ali.app', function (){
            $chargeContext = new ChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_CHANNEL_APP, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.ali.qr', function (){
            $chargeContext = new ChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_CHANNEL_QR, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.app', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_APP, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.wap', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_WAP, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.public', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_PUB, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.bar', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_BAR, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.miniProgram', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_LITE, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.qr', function (){
            $chargeContext = new ChargeContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initCharge(Config::WX_CHANNEL_QR, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.wechat.notify', function (){
            $chargeContext = new NotifyContext();
            $config = config('wechat.other_sdk_payment');
            $chargeContext->initNotify(Config::WX_CHARGE, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.ali.notify', function (){
            $chargeContext = new NotifyContext();
            $config = config('ali.payment');
            $chargeContext->initNotify(Config::ALI_CHARGE, $config);
            return $chargeContext;
        });

        $this->app->singleton('payment.notify', function (Application $app){
            return new PaymentNotify($app->make(OrderRepositoryEloquent::class));
        });

        $this->app->singleton('wechat.payment.aggregate', function (Application $application){
            return $application->make('payment.wechat.public');
        });

        $this->app->singleton('ali.payment.aggregate', function (Application $application){
            return $application->make('payment.ali.qr');
        });
    }
}