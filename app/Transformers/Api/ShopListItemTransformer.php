<?php

namespace App\Transformers\Api;

use League\Fractal\TransformerAbstract;
use App\Entities\Shop as ShopListItem ;

/**
 * Class ShopListItemTransformer.
 *
 * @package namespace App\Transformers\Api;
 */
class ShopListItemTransformer extends TransformerAbstract
{
    /**
     * Transform the ShopListItem entity.
     *
     * @param  ShopListItem $model
     *
     * @return array
     */
    public function transform(ShopListItem $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'position' => $model->position,
            'wait_write_off_buyers'   => $model->waitWriteOffBuyers()
        ];
    }
}
