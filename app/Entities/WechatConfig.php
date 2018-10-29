<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\WechatConfig
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string $appSecret 微信公众号secret
 * @property string $appName 微信公众号或者小程序名称
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICIAL_ACCOUNT 公众平台，
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string $mode 公众号模式
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property string|null $nickname 公众号或者小程序昵称
 * @property string|null $headImg 微信公众号或者小程序头像
 * @property string|null $userName 授权方公众号的原始ID
 * @property string|null $alias 授权方公众号所设置的微信号，可能为空
 * @property string|null $principalName 公众号的主体名称
 * @property string|null $qrcodeUrl 二维码图片的URL，开发者最好自行也进行保存
 * @property string|null $authCode
 * @property \Carbon\Carbon $authCodeExpiresIn
 * @property string|null $authInfoType
 * @property string|null $componentAccessToken 第三方平台access_token
 * @property \Carbon\Carbon $componentAccessTokenExpiresIn 有效期，为2小时
 * @property string|null $authorizerRefreshToken 授权刷新令牌
 * @property string|null $authorizerAccessToken 授权令牌
 * @property \Carbon\Carbon $authorizerAccessTokenExpiresIn 授权令牌,有效期，为2小时
 * @property array $serviceTypeInfo 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
 * @property array $verifyTypeInfo 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，
 *             3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
 * @property array $businessInfo 用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门
 *             店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
 * @property array $funcInfo 公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限
 *             2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限
 *             12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
 *             帐号类型和认证情况，来判断公众号的接口权限
 * @property array $miniProgramInfo 可根据这个字段判断是否为小程序类型授权
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\App|null $app
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
 * @property  1.消息管理权限
 *             2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 
 *             12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
 *             帐号类型和认证情况，来判断公众号的接口权限
 */
class WechatConfig extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const MINI_PROGRAM = 'MINI_PROGRAM';
    const OFFICIAL_ACCOUNT = 'OFFICIAL_ACCOUNT';

    protected $casts = [
        'service_type_info' => 'json',
        'verify_type_info'  => 'json',
        'business_info' => 'json',
        'func_info' => 'json',
        'mini_program_info'  => 'json',
        'component_access_token_expires_in' => 'date',
        'authorizer_access_token_expires_in' => 'date',
        'auth_code_expires_in' => 'date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id', 'app_secret', 'token', 'aes_key', 'type', 'mode', 'wechat_bind_app', 'app_name',
        'nickname', 'head_img', 'user_name', 'alias', 'principal_name', 'qrcode_url', 'auth_code',
        'auth_code_expires_in', 'auth_info_type', 'component_access_token', 'component_access_token_expires_in',
        'authorizer_refresh_token', 'authorizer_access_token', 'authorizer_access_token_expires_in', 'service_type_info',
        'verify_type_info', 'business_info', 'func_info', 'mini_program_info'
    ];

    public function menu() : HasOne
    {
        return $this->hasOne(WechatMenu::class, 'app_id', 'app_id');
    }

    public function app() :BelongsTo
    {
        return $this->belongsTo(App::class, 'wechat_bind_app', 'id');
    }
}
