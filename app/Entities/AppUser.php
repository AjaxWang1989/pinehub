<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\AppUser
 *
 * @property int $id
 * @property string $appId 系统应用id
 * @property int|null $userId 用户id
 * @property int $status 状态：0-冻结账号，1-激活 2-待激活
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\WechatUser $miniProgramUser
 * @property-read \App\Entities\WechatUser $officialAccountUser
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereUserId($value)
 * @mixin \Eloquent
 */
class AppUser extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;
    const FREEZE_ACCOUNT    = 0;
    const ACTIVATED_ACCOUNT = 1;
    const WAIT_AUTH_ACCOUNT = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'user_id',
        'status'
    ];

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function officialAccountUser()
    {
        return $this->hasOne(WechatUser::class, 'user_id', 'user_id')->where('type', WECHAT_OFFICIAL_ACCOUNT);
    }


    public function miniProgramUser()
    {
        return $this->hasOne(WechatUser::class, 'user_id', 'user_id')->where('type', WECHAT_MINI_PROGRAM);
    }
}
