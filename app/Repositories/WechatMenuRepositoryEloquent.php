<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatMenuRepository;
use App\Entities\WechatMenu;
use App\Validators\WechatMenuValidator;

/**
 * Class WechatMenuRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatMenuRepositoryEloquent extends BaseRepository implements WechatMenuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatMenu::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return WechatMenuValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
