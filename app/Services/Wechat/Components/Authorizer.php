<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/19
 * Time: 下午3:57
 */

namespace App\Services\Wechat\Components;
use Carbon\Carbon;

/**
 * @property string $authorizerAppid
 * @property string $authorizerAccessToken
 * @property Carbon $expiresIn
 * @property string $authorizerRefreshToken
 * @property array $funcInfo
 * */
class Authorizer
{
    protected $authInfo = [];

    public function __construct()
    {
        $authInfo = null;
        if(func_num_args() === 1 && is_array(func_get_arg(0))) {
            $authInfo = func_get_arg(0);
        }elseif (func_num_args() > 1 ) {
           $authInfo = func_get_args();
        }

        $authorizerAppid = null;
        $authorizerAccessToken = null;
        $authorizerExpires = null;
        $authorizerRefreshToken = null;
        $funcInfo = null;
        if($authInfo){
            if(func_num_args() === 5) {
                list($authorizerAppid, $authorizerAccessToken, $authorizerExpires, $authorizerRefreshToken, $funcInfo) = $authInfo;
            }elseif(func_num_args() === 4){
                list($authorizerAppid, $authorizerAccessToken, $authorizerExpires, $authorizerRefreshToken) = $authInfo;
            }
        }

        $this->authInfo = [
            "authorizer_appid" => $authorizerAppid,
            "authorizer_access_token" => $authorizerAccessToken,
            "expires_in" =>  Carbon::now()->addMinute($authorizerExpires),
            "authorizer_refresh_token" => $authorizerRefreshToken,
            "func_info"=> $funcInfo
        ];
    }

    /**
     * @return array
     */
    public function getAuthInfo(): array
    {
        return $this->authInfo;
    }

    /**
     * @return string
     */
    public function getAuthorizerAccessToken(): string
    {
        return $this->authInfo['authorizer_access_token'];
    }

    /**
     * @return string
     */
    public function getAuthorizerAppid(): string
    {
        return $this->authInfo['authorizer_appid'];
    }

    /**
     * @return string
     */
    public function getAuthorizerRefreshToken(): string
    {
        return $this->authInfo['authorizer_refresh_token'];
    }

    /**
     * @return Carbon
     */
    public function getExpiresIn(): Carbon
    {
        return $this->authInfo['expires_in'];
    }

    /**
     * @return array
     */
    public function getFuncInfo(): array
    {
        return $this->authInfo['func_info'];
    }
}