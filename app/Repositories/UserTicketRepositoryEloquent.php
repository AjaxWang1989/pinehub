<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserTicketRepository;
use App\Entities\UserTicket;
use App\Validators\UserTicketValidator;

/**
 * Class UserTicketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserTicketRepositoryEloquent extends BaseRepository implements UserTicketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserTicket::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function userTickets(int $status,$userId,$limit='15'){
        $this->scopeQuery(function (UserTicket $userTicket) use($status,$userId) {
            return $userTicket->with('tickets')->where(['user_id'=>$userId,'status'=>$status]);
        });
        return $this->paginate($limit);
    }
    
}
