<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Category as CategoryItem;

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
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'name' => $model->name,
            'icon' => $model->icon,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
