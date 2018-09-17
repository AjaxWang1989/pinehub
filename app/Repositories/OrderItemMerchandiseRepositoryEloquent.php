<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
