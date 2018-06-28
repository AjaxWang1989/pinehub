<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\WechatConfig
 *
 * @property int $id
 * @property string $appId 微信公众好app ID
 * @property string $appSecret 微信公众号secret
 * @property string $appName 微信公众号或者小程序名称
 * @property string|null $nickname
 * @property string|null $headImg
 * @property mixed|null $serviceTypeInfo
 * @property mixed|null $verifyTypeInfo
 * @property string|null $userName
 * @property string|null $principalName
 * @property string|null $alias
 * @property string|null $qrcodeUrl
 * @property mixed|null $businessInfo
 * @property mixed|null $funcInfo
 * @property mixed|null $miniProgramInfo
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICIAL_ACCOUNT 公众平台， 
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string $mode 公众号模式
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property string|null $authCode
 * @property string|null $authCodeExpiresIn
 * @property string|null $authInfoType
 * @property string|null $componentAccessToken
 * @property string|null $componentAccessTokenExpiresIn
 * @property string|null $authorizerRefreshToken
 * @property string|null $authorizerAccessTokenExpiresIn
 * @property string|null $authorizerAccessToken
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\WechatMenu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAesKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthCodeExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereBusinessInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereComponentAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereComponentAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereFuncInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereHeadImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereMiniProgramInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig wherePrincipalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereServiceTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereVerifyTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereWechatBindApp($value)
 * @mixin \Eloquent
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

    public function menu() : HasOne
    {
        return $this->hasOne(WechatMenu::class, 'app_id', 'app_id');
    }

}
