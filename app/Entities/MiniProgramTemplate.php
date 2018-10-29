<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\MiniProgramTemplate
 *
 * @property int $templateId 模版id
 * @property string $userVersion 模版版本号
 * @property string $userDesc 模版描述
 * @property string $createTime 模版创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereUserDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereUserVersion($value)
 * @mixin \Eloquent
 */
class MiniProgramTemplate extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
