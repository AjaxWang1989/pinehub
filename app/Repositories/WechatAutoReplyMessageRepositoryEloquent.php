<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\WechatAutoReplyMessage;

/**
 * Class WechatAutoReplyMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatAutoReplyMessageRepositoryEloquent extends BaseRepository implements WechatAutoReplyMessageRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatAutoReplyMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
