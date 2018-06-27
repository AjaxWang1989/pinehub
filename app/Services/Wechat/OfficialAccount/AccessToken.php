<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/26
 * Time: 下午1:48
 */

namespace App\Services\Wechat\OfficialAccount;
use Carbon\Carbon;

/**
 * the official account access token struct
 * @property string $openId
 * @property string $accessToken
 * @property Carbon expiresIn
 * @property string refreshToken
 * @property string $scope
 * */
class AccessToken implements \ArrayAccess
{
    /**
     * auth api return data
     * { "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE" }
     * @var array
     * */
    protected $accessToken = [];


    protected $cast = [
        'expires_id' => 'timestamp'
    ];
    public function __construct(array $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $accessToken
     * @return AccessToken
     * @throws
     * */
    public function setAccessToken(string  $accessToken)
    {
        $this->accessToken['access_token'] = $accessToken;
        return $this;
    }

    public function set(array $accessToken)
    {
        if(is_int($accessToken['expires_in'])) {
            $accessToken['expires_in'] = Carbon::now()->addMinute($accessToken['expires_in'])->format('Y-m-d h:i:s');
        }
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken['access_token'];
    }

    /**
     * @return Carbon
     */
    public function getExpiresIn(): Carbon
    {
        return $this->accessToken['expires_in'];
    }

    /**
     * @return string
     */
    public function getOpenId(): string
    {
        return $this->accessToken['open_id'];
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->accessToken['refresh_token'];
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->accessToken['scope'];
    }

    /**
     * @param Carbon $expiresIn
     */
    public function setExpiresIn(Carbon $expiresIn): void
    {
        $this->accessToken['expires_in'] = $expiresIn->format('Y-m-d h:i:s');
    }

    /**
     * @param string $openId
     */
    public function setOpenId(string $openId): void
    {
        $this->accessToken['open_id'] = $openId;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->accessToken['refresh_token'] = $refreshToken;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        return isset($this->accessToken[$offset]);
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        return $this->castType($offset);
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        $this->accessToken[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
        unset($this->accessToken[$offset]);
    }

    protected function castType($name = null)
    {
        foreach ($this->cast as $key => $type) {
            if($name && $key !== $name) {
                continue;
            }
            switch ($type) {
                case 'int':
                case 'integer': {
                    return (int)$this->accessToken[$key];
                    break;
                }
                case 'string': {
                    return (string)$this->accessToken[$key];
                    break;
                }
                case 'float': {
                    return (float)$this->accessToken[$key];
                    break;
                }
                case 'timestamp': {
                    return Carbon::parse($this->accessToken[$key]);
                    break;
                }
                default:
                    return $this->accessToken[$key];
                    break;
            }
        }
        return $this->accessToken[$name];
    }
}