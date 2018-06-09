<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\AuthSecretKey;

/**
 * Class AuthPublicKeyTransformer.
 *
 * @package namespace App\Transformers;
 */
class AuthPublicKeyTransformer extends TransformerAbstract
{
    /**
     * Transform the AuthPublicKey entity.
     *
     * @param \App\Entities\AuthSecretKey $model
     *
     * @return array
     */
    public function transform(AuthSecretKey $model)
    {
        return [
            'public_key' => $model->publicKey,
        ];
    }
}
