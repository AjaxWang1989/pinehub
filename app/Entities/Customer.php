<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * App\Entities\Customer
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property string|null $mobile 手机号码
 * @property int|null $memberId 会员id
 * @property string|null $platformAppId 微信公众平台、小程序、开放app id
 * @property string $type WECHAT_OFFICE_ACCOUNT 公众平台，
 *             WECHAT_OPEN_PLATFORM 微信开放平台 WECHAT_MINI_PROGRAM 微信小程序 ALIPAY_OPEN_PLATFORM  支付宝开发平台 SELF 平台客户
 * @property string|null $unionId union id
 * @property string $platformOpenId 三方平台用户唯一标志
 * @property string|null $sessionKey session key
 * @property \Illuminate\Support\Carbon $sessionKeyExpiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property array|null $privilege 微信特权信息
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property int $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道:0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $ticketRecords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePlatformAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePlatformOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSessionKeyExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserType($value)
 * @mixin \Eloquent
 */
class Customer extends Model implements AuthenticatableContract, AuthorizableContract, Transformable
{
    use Authenticatable, Authorizable, TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'session_key_expires_at' => 'date',
        'privilege' => 'json',
        'tags' => 'array'
    ];
    const WECHAT_OFFICE_ACCOUNT = 'WECHAT_OFFICE_ACCOUNT';
    const WECHAT_OPEN_PLATFORM = 'WECHAT_OPEN_PLATFORM';
    const WECHAT_MINI_PROGRAM = 'WECHAT_MINI_PROGRAM';
    const ALIPAY_OPEN_PLATFORM = 'ALIPAY_OPEN_PLATFORM';

    //注册：0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP

    //渠道：0-未知 1-微信 2-支付宝'
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'mobile',
        'member_id',
        'platform_app_id',
        'type',
        'union_id',
        'platform_open_id',
        'session_key',
        'session_key_expires_at',
        'avatar',
        'province',
        'city',
        'country',
        'nickname',
        'sex',
        'privilege',
        'is_student_certified',
        'user_type',
        'user_status',
        'is_certified',
        'can_use_score',
        'score',
        'total_score',
        'order_count',
        'channel',
        'register_channel',
        'tags'
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function ticketRecords() : HasMany
    {
        return $this->hasMany(CustomerTicketCard::class, 'customer_id', 'id');
    }

    public function getAuthPassword()
    {
        return Hash::make($this->sessionKey);
    }

    public function ordersNum()
    {
        $count = 0;
        $count += $this->orders->count();
        return $count;
    }
}
