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
        $this->app->singleton('ali.user.oauth', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_USER_OAUTH, $config);
            return $chargeContext;
        });

        $this->app->singleton('ali.oauth.token', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_OAUTH_TOKEN, $config);
            return $chargeContext;
        });

        $this->app->singleton('ali.user.info', function (){
            $chargeContext = new OauthChargeContext();
            $config = config('ali.payment');
            $chargeContext->initCharge(Config::ALI_USER_SHARE, $config);
            return $chargeContext;
        });
    }
}