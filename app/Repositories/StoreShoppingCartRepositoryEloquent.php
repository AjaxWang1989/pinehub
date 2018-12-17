<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\StoreShoppingCartRepository;
use App\Entities\StoreShoppingCart;
use App\Validators\StoreShoppingCartValidator;

/**
 * Class StoreShoppingCartRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StoreShoppingCartRepositoryEloquent extends BaseRepository implements StoreShoppingCartRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StoreShoppingCart::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
