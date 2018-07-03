<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\WechatConfig;

/**
 * Class WechatConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatConfigRepositoryEloquent extends BaseRepository implements WechatConfigRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'app_id' => 'like',
        'mode' => '=',
        'type' => '=',
        'wechat_bind_app' => '='
    ];
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
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
