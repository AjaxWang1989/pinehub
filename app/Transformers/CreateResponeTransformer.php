<?php

namespace App\Transformers;

use App\Http\Response\CreateResponse;
use League\Fractal\TransformerAbstract;

/**
 * Class CreateResponeTransformer.
 *
 * @package namespace App\Transformers;
 */
class CreateResponeTransformer extends TransformerAbstract
{
    /**
     * Transform the CreateRespone entity.
     *
     * @param CreateResponse $model
     *
     * @return array
     */
    public function transform(CreateResponse $model)
    {
        return $model->content();
    }
}
