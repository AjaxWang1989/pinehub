<?php

namespace App\Transformers;

use App\Entities\Merchandise;
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
            'status' => Merchandise::UP,
            'stock_num' => $model->stockNum,
            'sell_num' => $model->sellNum,
            'tags' => $model->tags,
            'describe' => $model->describe,
            'main_image' => $model->merchandise->mainImage,
        ];
    }
}
