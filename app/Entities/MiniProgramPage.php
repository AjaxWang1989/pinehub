<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\MiniProgramPage
 *
 * @property int $id
 * @property int $miniProgramTemplateId 小程序模版id
 * @property string $page 小程序页面路径
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereMiniProgramTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MiniProgramPage extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
