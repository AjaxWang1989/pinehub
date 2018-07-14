<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Customer
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property string|null $mobile
 * @property int|null $userId 会员id
 * @property string|null $platformAppId 微信公众平台、小程序、开放app id
 * @property string $type WECHAT_OFFICE_ACCOUNT 公众平台，
 *             WECHAT_OPEN_PLATFORM 微信开放平台 WECHAT_MINI_PROGRAM 微信小程序 ALIPAY_OPEN_PLATFORM  支付宝开发平台 SELF 平台客户
 * @property string|null $unionId union id
 * @property string $platformOpenId 三方平台用户唯一标志
 * @property string|null $sessionKey session key
 * @property \Carbon\Carbon $sessionKeyExpiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property array $privilege 微信特权信息
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
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\User|null $user
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserType($value)
 * @mixin \Eloquent
 */
class Customer extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'session_key_expires_at' => 'date',
        'privilege' => 'json',
        'tags' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'user_id',
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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id,', 'id');
    }
}
