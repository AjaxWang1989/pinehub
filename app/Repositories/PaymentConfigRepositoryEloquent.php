<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PaymentConfigRepository;
use App\Entities\PaymentConfig;
use App\Validators\PaymentConfigValidator;

/**
 * Class PaymentConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentConfigRepositoryEloquent extends BaseRepository implements PaymentConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentConfig::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
