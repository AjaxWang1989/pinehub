<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 0:03
 */
namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * App\Entities\WechatUser
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property int|null $userId 用户手机
 * @property string|null $wechatAppId 微信公众平台、小程序、开放app id
 * @property string $type OFFICE_ACCOUNT 公众平台，
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string|null $unionId union id
 * @property string $openId open id
 * @property string $sessionKey session key
 * @property \Carbon\Carbon $expiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property mixed|null $privilege 微信特权信息
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property \Carbon\Carbon $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereWechatAppId($value)
 * @mixin \Eloquent
 * @property string|null $mobile 手机号码
 * @property int|null $memberId 会员id
 * @property string|null $platformAppId 微信公众平台、小程序、开放app id
 * @property string $platformOpenId 三方平台用户唯一标志
 * @property \Illuminate\Support\Carbon $sessionKeyExpiresAt session 过期
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property int $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $orderCount 订单数
 * @property string|null $channel 渠道来源
 * @property string|null $registerChannel 注册渠道
 * @property array $tags 标签
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser wherePlatformAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser wherePlatformOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereSessionKeyExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUserType($value)
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $ticketRecords

 */
class   MpUser extends Customer
{
    const TYPE = 'MINI_PROGRAM';
    protected $table = 'customers';
}
