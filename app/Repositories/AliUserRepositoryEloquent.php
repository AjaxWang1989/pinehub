<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AliUserRepository;
use App\Entities\AliUser;
use App\Validators\AliUserValidator;

/**
 * Class AliUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AliUserRepositoryEloquent extends BaseRepository implements AliUserRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AliUser::class;
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
