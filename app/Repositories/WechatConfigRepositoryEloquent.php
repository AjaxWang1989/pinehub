<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatConfigRepository;
use App\Entities\WechatConfig;
use App\Validators\WechatConfigValidator;

/**
 * Class WechatConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatConfigRepositoryEloquent extends BaseRepository implements WechatConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatConfig::class;
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
