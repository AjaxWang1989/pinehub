<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Category
 *
 * @property int $id
 * @property string|null $appId 系统app id
 * @property string $icon 图标
 * @property string $name 分类名称
 * @property int $parentId 分类父级
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Merchandise[] $merchandises
 * @property-read \App\Entities\Category $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['app_id', 'icon', 'name', 'parent_id'];


    public function children() : HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function merchandises() : BelongsToMany
    {
        return $this->belongsToMany(Merchandise::class, 'merchandise_categories',
            'category_id', 'merchandise_id');
    }
}