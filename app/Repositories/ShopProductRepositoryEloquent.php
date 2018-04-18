<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShopProductRepository;
use App\Entities\ShopProduct;
use App\Validators\ShopProductValidator;

/**
 * Class ShopProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopProductRepositoryEloquent extends BaseRepository implements ShopProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopProduct::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
