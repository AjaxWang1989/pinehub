<?php

namespace App\Transformers\Api;

use App\Entities\PaymentSigned;
use Illuminate\Support\Facades\Log;
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
        Log::debug('signed data', $model->data());
        return $model->data();
    }
}
