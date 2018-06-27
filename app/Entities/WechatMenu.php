<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\WechatMenu
 *
 * @property int $id
 * @property array $menus 	菜单的响应动作类型，view表示网页类型，click表示点击类型，miniprogram表示小程序类型
 * @property string|null $appid 小程序的appid（仅认证公众号可配置）
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereAppid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereMenus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $isPublic 是否发布
 * @property string|null $name 菜单名称
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereName($value)
 * @property string $appId app id
 */
class WechatMenu extends Model implements Transformable
{
    use TransformableTrait;

    protected $casts = [
        'menus' => 'array'
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
