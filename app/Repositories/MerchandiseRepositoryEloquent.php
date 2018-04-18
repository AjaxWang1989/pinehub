<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MerchandiseRepository;
use App\Entities\Merchandise;
use App\Validators\MerchandiseValidator;

/**
 * Class MerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MerchandiseRepositoryEloquent extends BaseRepository implements MerchandiseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Merchandise::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
