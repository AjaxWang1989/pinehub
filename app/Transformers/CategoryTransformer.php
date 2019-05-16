<?php

namespace App\Transformers;

use App\Entities\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id' => (int)$model->id,
            /* place your other model properties here */
            'name' => $model->name,
            'icon' => $model->icon,
            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt
        ];
    }
}
