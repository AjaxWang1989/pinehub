<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderPostRepository;
use App\Entities\OrderPost;
use App\Validators\OrderPostValidator;

/**
 * Class OrderPostRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderPostRepositoryEloquent extends BaseRepository implements OrderPostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderPost::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
