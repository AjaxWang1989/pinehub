<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatUserRepository;
use App\Entities\WechatUser;
use App\Validators\WechatUserValidator;

/**
 * Class WechatUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatUserRepositoryEloquent extends BaseRepository implements WechatUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
