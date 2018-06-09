<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WechatMaterial.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $appId 微信app id
 * @property int $isTemp 是否临时素材
 * @property string $type 素材类型
 * @property mixed $content 素材内容
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereIsTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WechatMaterial extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
