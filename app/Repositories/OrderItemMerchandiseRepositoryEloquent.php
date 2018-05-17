<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderItemMerchandiseRepository;
use App\Entities\OrderItemMerchandise;
use App\Validators\OrderItemMerchandiseValidator;

/**
 * Class OrderItemMerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderItemMerchandiseRepositoryEloquent extends BaseRepository implements OrderItemMerchandiseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderItemMerchandise::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
