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
    protected $defaultIncludes = [
        'children'
    ];

    protected $availableIncludes = [
        'children'
    ];

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
            'key' => $model->key,
            'icon' => $model->icon,
            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt
        ];
    }

    public function includeChildren(Category $category)
    {
        $children = $category->children;

        return $children ? $this->collection($children, new CategoryTransformer) : null;
    }
}
