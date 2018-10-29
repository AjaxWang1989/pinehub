<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;
/**
 * App\Entities\Group
 *
 * @property int $id
 * @property string $code 部门编号
 * @property string $displayName 部门名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Group extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'display_name'];

    public function roles() : HasMany
    {
        return $this->hasMany(Role::class, 'group_id', 'id');
    }

}
