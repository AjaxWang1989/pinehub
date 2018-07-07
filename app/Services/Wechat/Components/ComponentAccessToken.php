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

    public function __construct($authInfo)
    {
        $this->authInfo = $authInfo;
        $this->authInfo['expires_in'] = Carbon::now()->addMinute($authInfo['expires_in']);
    }


    public function __get($name)
    {
        // TODO: Implement __get() method.\
        $key = upperCaseSplit($name, '_');
        return $this->authInfo[$key];
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