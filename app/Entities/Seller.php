<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Entities\Seller
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereVipLevel($value)
 * @mixin \Eloquent
 * @property float|null $balance 用户余额
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\User $shop
 */
class Seller extends User
{
  protected $table = 'users';

  public function shop() :HasOne
  {
        return $this->HasOne(User::class,'user_id','id');
  }
}
