<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WechatConfig.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $appId 微信公众好app ID
 * @property string $appSecret 微信公众号secret
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICE_ACCOUNT 公众平台，
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAesKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereWechatBindApp($value)
 * @mixin \Eloquent
 * @property string|null $mode 微信模式
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereMode($value)
 * @property string|null $appName 应用名称
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppName($value)
 */
class WechatConfig extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id', 'app_secret', 'token', 'aes_key', 'type', 'mode', 'wechat_bind_app', 'app_name'
    ];

}
