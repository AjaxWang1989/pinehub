<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Customer;
use App\Validators\CustomerValidator;
use App\Repositories\Traits\RepositoryRelationShip;
use App\Criteria\Admin\SearchRequestCriteria;

/**
 * Class CustomerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{
    use Destruct, RepositoryRelationShip;
    protected $fieldSearchable = [
        'channel' => '=',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(SearchRequestCriteria::class));
    }

}
