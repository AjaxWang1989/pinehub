<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/7
 * Time: 下午9:12
 */

namespace App\Services\Wechat\OpenPlatform;
use Carbon\Carbon;

/**
 * @property string $authorizerAccessToken
 * @property string $authorizerRefreshToken
 * @property Carbon $expiresIn
 * */
class OpenPlatformAccessToken
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->data['expires_in'] = Carbon::now()->addMinute($data['expires_in']);
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        $key = upperCaseSplit($name, '_');
        return $this->data[$key];
    }
}