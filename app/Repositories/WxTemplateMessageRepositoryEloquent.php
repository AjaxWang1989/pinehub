<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WxTemplateMessageRepository;
use App\Entities\WxTemplateMessage;
use App\Validators\WxTemplateMessageValidator;

/**
 * Class WxTemplateMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WxTemplateMessageRepositoryEloquent extends BaseRepository implements WxTemplateMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WxTemplateMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
