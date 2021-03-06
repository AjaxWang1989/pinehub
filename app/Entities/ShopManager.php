<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\ShopManager
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
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @property-read   Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereVipLevel($value)
 * @mixin \Eloquent
 */
class ShopManager extends User
{
    protected $table = 'users';

    public function shops():HasMany
    {
        return $this->hasMany(Shop::class, 'user_id', 'id');
    }

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class, 'user_id', 'id');
    }
}
