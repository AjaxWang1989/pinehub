<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 */
class WechatUser extends Model  implements AuthenticatableContract, AuthorizableContract, Transformable
{
    use Authenticatable, Authorizable, TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'expires_at' => 'date',
        'tagid_list' => 'json',
        'subscribe_time' => 'date',
        'deleted_at' => 'date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'app_id', 'wechat_app_id', 'type', 'union_id',
        'open_id', 'session_key', 'expires_at', 'avatar', 'country',
        'province', 'city', 'nickname', 'sex', 'privilege',
        'tagid_list', 'remark', 'subscribe_time', 'group_id',
        'subscribe', 'subscribe_scene', 'qr_scene', 'qr_scene_str'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'open_id', 'open_id')->where('type', 'WECHAT_PAY');
    }
}
