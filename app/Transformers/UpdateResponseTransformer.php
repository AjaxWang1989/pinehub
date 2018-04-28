<?php

namespace App\Transformers\Api;

use App\Http\Response\UpdateResponse;
use League\Fractal\TransformerAbstract;

/**
 * Class UpdateResponseTransformer.
 *
 * @package namespace App\Transformers\Api;
 */
class UpdateResponseTransformer extends TransformerAbstract
{
    /**
     * Transform the UpdateResponse entity.
     *
     * @param UpdateResponse $model
     *
     * @return array
     */
    public function transform(UpdateResponse $model)
    {
        return $model->content();
    }
}
