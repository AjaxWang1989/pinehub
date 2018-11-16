<?php

namespace App\Repositories;

use App\Criteria\Admin\PaymentActivityCriteria;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\PaymentActivity;

/**
 * Class PaymentActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentActivityRepositoryEloquent extends BaseRepository implements PaymentActivityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentActivity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {

    }

}
