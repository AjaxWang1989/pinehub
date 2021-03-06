<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\SKUProduct;
use App\Validators\SKUProductValidator;

/**
 * Class SKUProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SKUProductRepositoryEloquent extends BaseRepository implements SKUProductRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SKUProduct::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
