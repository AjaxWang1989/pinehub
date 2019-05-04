<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketTemplateMessageRepository;
use App\Entities\TicketTemplateMessage;
use App\Validators\TicketTemplateMessageValidator;

/**
 * Class TicketTemplateMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketTemplateMessageRepositoryEloquent extends BaseRepository implements TicketTemplateMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketTemplateMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
