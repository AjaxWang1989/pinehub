<?php

namespace App\Transformers;

use App\Entities\Category as CategoryItem;
use App\Repositories\MerchandiseCategoryRepository;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CategoryItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CategoryItem entity.
     *
     * @param CategoryItem $model
     *
     * @return array
     */
    public function transform(CategoryItem $model)
    {
        return [
            'id' => (int)$model->id,
            /* place your other model properties here */
            'name' => $model->name,
            'icon' => $model->icon,
            'merchandise_num' => count(app()->make(MerchandiseCategoryRepository::class)->findWhere(['category_id' => $model->id])),
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
