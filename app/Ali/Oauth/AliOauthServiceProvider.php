<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:40
 */

namespace App\Ali\Oauth;


use Illuminate\Support\ServiceProvider;

class AliOauthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('web.ali.user.oauth', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_USER_OAUTH, $config);
            return $chargeContext;
        });

        $this->app->singleton('web.ali.oauth.token', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_OAUTH_TOKEN, $config);
            return $chargeContext;
        });

        $this->app->singleton('web.ali.user.info', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_USER_SHARE, $config);
            return $chargeContext;
        });

        $this->app->singleton('mp.ali.user.oauth', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.mini_program');
            $chargeContext->initCharge(Config::ALI_USER_OAUTH, $config);
            return $chargeContext;
        });

        $this->app->singleton('mp.ali.oauth.token', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.mini_program');
            $chargeContext->initCharge(Config::ALI_OAUTH_TOKEN, $config);
            return $chargeContext;
        });

        $this->app->singleton('mp.ali.user.info', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.mini_program');
            $chargeContext->initCharge(Config::ALI_USER_SHARE, $config);
            return $chargeContext;
        });
    }
}