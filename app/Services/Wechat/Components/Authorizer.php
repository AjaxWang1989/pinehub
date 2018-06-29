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

    public function __construct($authInfo)
    {
        $this->authInfo = $authInfo;
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