<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\WechatMenu
 *
 * @property int $id
 * @property string $appId 微信app id
 * @property string|null $name 菜单名称
 * @property int $isPublic 菜单是否发布
 * @property array $menus menus
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereMenus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WechatMenu extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'menus' => 'json'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id','menus', 'name', 'is_public'
    ];

}
