<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TakeOutCarRepository;
use App\Entities\TakeOutCar;
use App\Validators\TakeOutCarValidator;

/**
 * Class TakeOutCarRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TakeOutCarRepositoryEloquent extends BaseRepository implements TakeOutCarRepository
{
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
