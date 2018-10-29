<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Administrator.
 *
 * @package namespace App\Entities;
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
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property string|null $channel 渠道来源
 * @property string|null $registerChannel 注册渠道
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property float|null $balance 用户余额
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereVipLevel($value)
 * @mixin \Eloquent
 */
class Administrator extends User
{
    protected $table = 'users';
}
