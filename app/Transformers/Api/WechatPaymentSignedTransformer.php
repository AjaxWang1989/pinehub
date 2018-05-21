<?php

namespace App\Transformers\Api;

use League\Fractal\TransformerAbstract;

/**
 * Class WechatPaymentSignedTransformer.
 *
 * @package namespace App\Transformers\Api;
 */
class WechatPaymentSignedTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatPaymentSigned entity.
     *
     * @param mixed $model
     * @return array
     */
    public function transform($model)
    {
        return $model;
    }
}
