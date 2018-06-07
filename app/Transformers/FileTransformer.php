<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\File;

/**
 * Class FileTransformerTransformer.
 *
 * @package namespace App\Transformers;
 */
class FileTransformer extends TransformerAbstract
{
    /**
     * Transform the FileTransformer entity.
     *
     * @param \App\Entities\File $model
     *
     * @return array
     */
    public function transform(File $model)
    {
        return [
            'id'         => (int) $model->id,
            'path'       => $model->path,
            /* place your other model properties here */
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
