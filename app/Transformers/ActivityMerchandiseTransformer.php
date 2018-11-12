<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ActivityMerchandise;

/**
 * Class ActivityMerchandiseTransformer.
 *
 * @package namespace App\Transformers;
 */
class ActivityMerchandiseTransformer extends TransformerAbstract
{
    /**
     * Transform the ActivityMerchandiseTransformer entity.
     *
     * @param \App\Entities\ActivityMerchandise $model
     *
     * @return array
     */
    public function transform(ActivityMerchandise $model)
    {
        return [
            'id'=>$model->id,
            'merchandise_id'=>$model->merchandiseId,
            'name' => $model->merchandise->name,
            'sell_price' => $model->merchandise->sellPrice,
            'origin_price' => $model->merchandise->originPrice,
            'stock_num' => $model->stockNum,
            'sell_num' => $model->sellNum,
            'tags' => explode(',', $model->tags),
            'describe' => $model->describe,
            'main_image' => $model->merchandise->mainImage,
        ];
    }
}
