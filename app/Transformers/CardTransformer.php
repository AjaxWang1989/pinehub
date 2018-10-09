<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Card;

/**
 * Class CardTransformer.
 *
 * @package namespace App\Transformers;
 */
class CardTransformer extends TransformerAbstract
{
    /**
     * Transform the Card entity.
     *
     * @param \App\Entities\Card $model
     *
     * @return array
     */
    public function transform(Card $model)
    {
        return $model->toArray();
    }
}
