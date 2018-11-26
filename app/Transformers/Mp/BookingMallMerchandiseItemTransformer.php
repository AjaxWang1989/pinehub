<?php

namespace App\Transformers\Mp;

use App\Entities\Merchandise;
use League\Fractal\TransformerAbstract;
use App\Entities\Mp\BookingMallMerchandiseItem;

/**
 * Class BookingMallMerchandiseItemTransformer.
 *
 * @package namespace App\Transformers\Mp;
 */
class BookingMallMerchandiseItemTransformer extends TransformerAbstract
{
    /**
     * Transform the BookingMallMerchandiseItem entity.
     *
     * @param \App\Entities\Merchandise $model
     *
     * @return array
     */
    public function transform(Merchandise $model)
    {
        return [
            'id'         => (int) $model->id,
            'merchandise_id' => (int) $model->id,
            'name'=> $model->name,
            'main_image'=> $model->mainImage,
            'origin_price' => number_format($model->originPrice,2),
            'sell_price' => number_format($model->sellPrice,2),
            'stock_num' => (int) $model->stockNum,
            'sell_num' => (int) $model->sellNum,
        ];
    }
}
