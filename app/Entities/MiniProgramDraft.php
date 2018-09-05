<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MiniProgramDraft.
 *
 * @package namespace App\Entities;
 * @property int $draftId 草稿id
 * @property string $userVersion 模版版本号
 * @property string $userDesc 模版描述
 * @property string $createTime 草稿创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereDraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereUserDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereUserVersion($value)
 * @mixin \Eloquent
 */
class MiniProgramDraft extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
