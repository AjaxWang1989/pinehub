<?php

namespace App\Repositories;

use App\Entities\Role;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdministratorRepository;
use App\Entities\Administrator;

/**
 * Class AdministratorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdministratorRepositoryEloquent extends BaseRepository implements AdministratorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Administrator::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        Administrator::created(function (Administrator $administrator) {
            $role = Role::whereSlug(Role::SYS_ADMIN)->first();
            $administrator->roles()->sync([$role->id]);
        });
    }
    
}
