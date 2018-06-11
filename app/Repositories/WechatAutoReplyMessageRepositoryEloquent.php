<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatAutoReplyMessageRepository;
use App\Entities\WechatAutoReplyMessage;
use App\Validators\WechatAutoReplyMessageValidator;

/**
 * Class WechatAutoReplyMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatAutoReplyMessageRepositoryEloquent extends BaseRepository implements WechatAutoReplyMessageRepository
{
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
