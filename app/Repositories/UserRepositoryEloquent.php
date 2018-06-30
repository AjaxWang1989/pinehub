<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Entities\User;

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
        'mobile'    => '=',
        'sex' => '=',
        'roles.slug' => '=',
        'roles.display_name' => 'like',
        'roles.group.display_name' => 'like',
        'channel' => '=',
        'register_channel' => '=',
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

    }
}
