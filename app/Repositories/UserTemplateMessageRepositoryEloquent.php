<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserTemplateMessageRepository;
use App\Entities\UserTemplateMessage;
use App\Validators\UserTemplateMessageValidator;

/**
 * Class UserTemplateMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserTemplateMessageRepositoryEloquent extends BaseRepository implements UserTemplateMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserTemplateMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
