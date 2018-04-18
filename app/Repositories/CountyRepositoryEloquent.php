<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CountyRepository;
use App\Entities\County;
use App\Validators\CountyValidator;

/**
 * Class CountyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CountyRepositoryEloquent extends BaseRepository implements CountyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return County::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
