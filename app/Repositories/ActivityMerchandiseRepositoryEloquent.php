<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ActivityMerchandiseRepository;
use App\Entities\ActivityMerchandise;
use App\Validators\ActivityMerchandiseValidator;

/**
 * Class ActivityMerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ActivityMerchandiseRepositoryEloquent extends BaseRepository implements ActivityMerchandiseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ActivityMerchandise::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
