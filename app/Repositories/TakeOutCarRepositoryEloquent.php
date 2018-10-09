<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\TakeOutCar;

/**
 * Class TakeOutCarRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TakeOutCarRepositoryEloquent extends BaseRepository implements TakeOutCarRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TakeOutCar::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
