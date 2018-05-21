<?php

namespace App\Transformers\Api;

use App\Entities\WechatPaymentSigned;
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
     * @param WechatPaymentSigned $model
     * @return array
     */
    public function transform(WechatPaymentSigned $model)
    {
        return $model->data();
    }
}
