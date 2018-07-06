<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * App\Entities\Member
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Carbon\Carbon $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property string|null $channel 渠道来源
 * @property string|null $registerChannel 注册渠道
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereVipLevel($value)
 * @mixin \Eloquent
 */
class Member extends Model implements AuthenticatableContract, AuthorizableContract, Transformable
{
    use Authenticatable, Authorizable, TransformableTrait, ModelAttributesAccess;

    const FREEZE_ACCOUNT    = 0;
    const ACTIVATED_ACCOUNT = 1;
    const WAIT_AUTH_ACCOUNT = 2;

    protected $table = "users";

    protected $casts = [
        'last_login_at' => 'date',
        'tags' => 'json'
    ];

    protected $dates = [
        'last_login_at'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'mobile', 'password', 'nickname', 'sex', 'avatar', 'city', 'vip_level',
        'last_login_at', 'status', 'mobile_company'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->whereHas('roles', function ($query) {
            $query->where('slug', Role::MEMBER);
        });
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')
            ->withTimestamps();
    }

    public function apps() : BelongsToMany
    {
        return $this->belongsToMany(App::class, 'app_users', 'user_id', 'app_id');
    }

    public function customers() : HasMany
    {
        return $this->hasMany(Customer::class, 'user_id', 'id');
    }

    /**
     * @return  Customer|null
     * */
    public function officialAccountCustomer()
    {
        return $this->customers ? $this->customers->where('type',
            'WECHAT_OFFICIAL_ACCOUNT')->first( ) : null;
    }

    /**
     * @return  Customer|null
     * */
    public function miniProgramCustomer()
    {
        return $this->customers ? $this->customers->where('type',
            'WECHAT_MINI_PROGRAM')->first( ) : null;
    }

    public function memberCard(): HasOne
    {
        return $this->hasOne(MemberCard::class, 'user_id', 'id');
    }

    public function ordersNum()
    {
        $count = 0;
        foreach ($this->customers as $customer){
            $count += $customer->orders->count();
        }
        return $count;
    }
}
