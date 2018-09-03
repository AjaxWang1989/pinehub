<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShopMerdandiseRepository;
use App\Entities\ShopMerdandise;
use App\Validators\ShopMerdandiseValidator;

/**
 * Class ShopMerdandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopMerchandiseRepositoryEloquent extends BaseRepository implements ShopMerdandiseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopMerdandise::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
