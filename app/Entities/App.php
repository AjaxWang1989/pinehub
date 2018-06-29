<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property string|null $wechatAppId 系统标示
 * @property string|null $miniAppId
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\WechatConfig|null $miniProgram
 * @property-read \App\Entities\WechatConfig|null $officialAccount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereMiniAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereWechatAppId($value)
 * @mixin \Eloquent
 */
class App extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'secret',
        'logo',
        'wechat_app_id',
        'mini_app_id'
    ];

    public function officialAccount(): BelongsTo
    {
        return $this->belongsTo(WechatConfig::class, 'wechat_app_id', 'app_id')->where('type', WECHAT_OFFICIAL_ACCOUNT);
    }

    public function miniProgram(): BelongsTo
    {
        return $this->belongsTo(WechatConfig::class, 'mini_app_id', 'app_id')->where('type', WECHAT_MINI_PROGRAM);
    }

}
