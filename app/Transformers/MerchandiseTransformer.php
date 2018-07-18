<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Merchandise;

/**
 * Class MerchandiseTransformer.
 *
 * @package namespace App\Transformers;
 */
class MerchandiseTransformer extends TransformerAbstract
{
    /**
     * Transform the Merchandise entity.
     *
     * @param \App\Entities\Merchandise $model
     *
     * @return array
     */
    public function transform(Merchandise $model)
    {
        return [
            'id'         => (int) $model->id,
            'categories' => $model->categories,
            /* place your other model properties here */
            'app_id' => $model->appId,
            'code' => $model->code,
            'name' => $model->name,
            'main_image' => $model->mainImage,
            'images' => $model->images,
            'preview' => $model->preview,
            'detail' => $model->detail,
            'origin_price' => $model->originPrice,
            'sell_price' => $model->sellPrice,
            'cost_price' => $model->costPrice,
            'factory_price' => $model->factoryPrice,
            'stock_num' => $model->stockNum,
            'status' => $model->status,
            'sell_num' => $model->sellNum,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
