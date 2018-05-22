<?php

namespace App\Transformers\Api;

use App\Entities\PaymentSigned;
use League\Fractal\TransformerAbstract;

/**
 * Class PaymentSignedTransformer.
 *
 * @package namespace App\Transformers\Api;
 */
class PaymentSignedTransformer extends TransformerAbstract
{
    /**
     * Transform the PaymentSigned entity.
     *
     * @param PaymentSigned $model
     * @return array
     */
    public function transform(PaymentSigned $model)
    {
        return $model->data();
    }
}
