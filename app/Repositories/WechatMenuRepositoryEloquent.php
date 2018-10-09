<?php

namespace App\Repositories;

use App\Criteria\Admin\WechatMenuCriteria;
use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\WechatMenu;

/**
 * Class WechatMenuRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatMenuRepositoryEloquent extends BaseRepository implements WechatMenuRepository
{
    use Destruct;
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
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(WechatMenuCriteria::class);
    }
    
}
