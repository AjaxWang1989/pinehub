<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Customer;

/**
 * Class CustomerTransformer.
 *
 * @package namespace App\Transformers;
 */
class CustomerTransformer extends TransformerAbstract
{
    /**
     * Transform the Customer entity.
     *
     * @param Customer $model
     *
     * @return array
     */
    public function transform(Customer $model)
    {
        return $model->toArray();
    }
}
