<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\App
 *
 * @property string $id app id
 * @property string $secret 应用secret
 * @property string $name 应用名称
 * @property string $logo 应用logo
 * @property string|null $wechatAppId 微信公众号appid
 * @property string|null $miniAppId 小程序appid
 * @property string|null $openAppId api创建open platform appid
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\AppUser[] $appUsers
 * @property-read \App\Entities\MiniProgram|null $miniProgram
 * @property-read \App\Entities\OfficialAccount|null $officialAccount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereMiniAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereOpenAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereWechatAppId($value)
 * @mixin \Eloquent
 * @property int|null $ownerUserId 应用拥有者
 * @property string $concatPhoneNum 联系电话
 * @property-read \App\Entities\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereConcatPhoneNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereOwnerUserId($value)
 * @property string $contactName 联系人名称
 * @property string $contactPhoneNum 联系电话
 * @property  int $shopsCount
 * @property  int $ordersCount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereContactPhoneNum($value)
 */
class App extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $keyType = 'string';

    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'owner_user_id',
        'name',
        'secret',
        'logo',
        'contact_phone_num',
        'contact_name',
        'wechat_app_id',
        'mini_app_id',
        'open_app_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id', 'id');
    }

    public function shops() : HasMany
    {
        return $this->hasMany(Shop::class, 'app_id', 'id');
    }

    public function officialAccount(): BelongsTo
    {
        return $this->belongsTo(OfficialAccount::class, 'wechat_app_id', 'app_id')->where('type', WECHAT_OFFICIAL_ACCOUNT);
    }

    public function miniProgram(): BelongsTo
    {
        return $this->belongsTo(MiniProgram::class, 'mini_app_id', 'app_id')->where('type', WECHAT_MINI_PROGRAM);
    }



    public function users() : HasMany
    {
        return $this->hasMany(User::class, 'app_id', 'id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'app_id', 'id');
    }
}
