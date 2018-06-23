<?php

namespace App\Repositories;

use App\Criteria\UserCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Entities\User;
use App\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    protected $fieldSearchable = [
        'user_name' => 'like',
        'nickname'  => 'like',
        'mobile'    => 'like',
        'sex',
        'roles.slug' => 'like',
        'roles.display_name' => 'like',
        'roles.group.display_name' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(UserCriteria::class));
    }
}
