<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SKUProductRepository;
use App\Entities\SKUProduct;
use App\Validators\SKUProductValidator;

/**
 * Class SKUProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SKUProductRepositoryEloquent extends BaseRepository implements SKUProductRepository
{
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
