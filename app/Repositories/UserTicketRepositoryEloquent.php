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

    /**
     * @param int $status
     * @param int $userId
     * @param string $shoppingCartAmount
     * @return mixed
     */
    public function userTickets(int $status, int $userId, string $shoppingCartAmount){
        $shoppingCartAmount = $shoppingCartAmount*100;
        $this->scopeQuery(function (UserTicket $userTicket) use($status, $userId, $shoppingCartAmount) {
            return $userTicket->where(['user_id'=>$userId,'user_tickets.status'=>$status])
                ->join('cards', 'user_tickets.card_id', '=', 'cards.card_id')
                ->where('cards.card_info->cash->least_cost', '<=', $shoppingCartAmount)
                ->where('cards.card_info->cash->date_info->begin_timestamp','<=',time())
                ->where('cards.card_info->cash->date_info->end_timestamp','>',time());
        });
        return $this->paginate();
    }
    
}
