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
        $oauth = app('ali.user.info')->charge(['authToken' => $token['access_token']]);
        return $oauth;
    }

    /**
     * @param null $code
     * @param string $type
     * @return mixed|null
     */
    public function getToken($code = null, string $type = 'mp')
    {
//        if(($token = Cache::get($this->getCacheKey($code)))) {
//            return $token;
//        }
//        if ($type === 'mp')
//            $token = app('mp.ali.oauth.token')->charge($this->getCredentials($code))->getToken();
//        else
//            $token = app('web.ali.oauth.token')->charge($this->getCredentials($code))->getToken();
//        Cache::put($this->getCacheKey($code), $token, $token['expires_in']);
        return app('mp.ali.oauth.token')->charge($this->getCredentials($code))->getToken();
    }

    protected function getCredentials($code = null) : array
    {
        if(!$code) {
            $code = Request::input('auth_code');
        }

        return [
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
    }

    protected function getCacheKey()
    {
        return 'ali.oauth.token'.md5(json_encode($this->getCredentials()));
    }
}