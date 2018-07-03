<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AppUserRepository;
use App\Entities\AppUser;
use App\Validators\AppUserValidator;

/**
 * Class AppUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AppUserRepositoryEloquent extends BaseRepository implements AppUserRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AppUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
