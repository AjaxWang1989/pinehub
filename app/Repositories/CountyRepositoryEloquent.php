<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\County;

/**
 * Class CountyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CountyRepositoryEloquent extends BaseRepository implements CountyRepository
{
    use Destruct;
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
