<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\MerchandiseCategory
 *
 * @property int $id
 * @property int $categoryId 分类id
 * @property int $merchandiseId 产品id
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Category $category
 * @property-read \App\Entities\Merchandise $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchandiseCategory extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'merchandise_id'];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

}
