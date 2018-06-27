<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * App\Entities\WechatUser
 *
 * @property int $id
 * @property int|null $userId 用户ID
 * @property string|null $wechatAppId 微信公众平台、小程序、开放app id
 * @property string|null $appId
 * @property string $type OFFICE_ACCOUNT 公众平台，
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string|null $unionId union id
 * @property string $openId open id
 * @property string $sessionKey session key
 * @property string $expiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property string|null $privilege 微信特权信息
 * @property string|null $subscribeTime
 * @property string|null $remark
 * @property string|null $groupId
 * @property mixed|null $tagidList
 * @property int|null $subscribe
 * @property string|null $subscribeScene
 * @property string|null $qrScene
 * @property string|null $qrSceneStr
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereQrScene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereQrSceneStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSubscribeScene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSubscribeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereTagidList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereWechatAppId($value)
 * @mixin \Eloquent
 */
class WechatUser extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
