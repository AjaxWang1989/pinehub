<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/16
 * Time: 上午8:57
 */

namespace App\Services\AliPay;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class AliPayService
{
    /**
     * @throws
     * */
    public function oauth()
    {
        $token = $this->getToken();
        $oauth = app('ali.user.info')->charge(['auth_token' => $token['access_token']]);
        return $oauth;
    }

    /**
     * @throws
     * */
    public function getToken()
    {
        if(($token = Cache::get($this->getCacheKey()))) {
            return $token;
        }
        $token = app('ali.oauth.token')->charge($this->getCredentials())->getToken();
        Cache::put($this->getCacheKey(), $token, $token['expires_in']);
        \Log::debug('ali token', $token);
        return $token;
    }

    protected function getCredentials() : array
    {
        $code = Request::input('auth_code');
        return [
            'grant_type' => 'authorization_code', 'code' => $code
        ];
    }

    protected function getCacheKey()
    {
        return 'ali.oauth.'.md5(json_encode($this->getCredentials()));
    }
}