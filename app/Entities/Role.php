<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * App\Entities\AdminRole
 *
 * @property int $id
 * @property string $slug 角色标识
 * @property string $displayName 角色显示名称
 * @property int|null $groupId 部门组织id
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\Group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const SUPPER_ADMIN = 'super.administer';
    const SYS_ADMIN = 'sys.administer';
    const DEVELOPER    = 'developer.administer';
    const TESTER     = 'tester.administer';
    const CUSTOMER     = 'customer';
    const MEMBER     = 'member';
    const SHOP_MANAGER = 'shop.manager';
    const SELLER = 'seller';
    const STRANGER =  'stranger';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'slug', 'display_name'
    ];

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'user_id', 'role_id');
    }

}
