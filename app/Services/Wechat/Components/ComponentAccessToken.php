<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/28
 * Time: 下午5:35
 */

namespace App\Services\Wechat\Components;
use Carbon\Carbon;

/**
 * @property string $componentAccessToken
 * @property Carbon $expiresIn
 * */
class ComponentAccessToken
{
    protected $authInfo = [];

    public function __construct()
    {
        if(func_num_args() === 0 && is_array(func_get_arg(0))) {
            $this->authInfo = func_get_arg(0);
        }elseif (func_num_args() > 1 ) {
            $componentAppid = null;
            $componentAccessToken = null;
            $componentExpires = null;
            $componentRefreshToken = null;
            $funcInfo = null;
            if(func_num_args() === 2) {
                list($componentAccessToken, $componentExpires) = func_get_args();
            }
            $this->authInfo = [
                "component_access_token" => $componentAccessToken,
                "expires_in" =>  Carbon::now()->addMinute($componentExpires),
            ];
        }
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
    public function getComponentAccessToken(): string
    {
        return $this->authInfo['component_access_token'];
    }

    /**
     * @return Carbon
     */
    public function getExpiresIn(): Carbon
    {
        return $this->authInfo['expires_in'];
    }
}