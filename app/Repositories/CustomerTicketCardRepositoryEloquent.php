<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\CustomerTicketCard;
use App\Validators\CustomerTicketCardValidator;

/**
 * Class CustomerTicketCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CustomerTicketCardRepositoryEloquent extends BaseRepository implements CustomerTicketCardRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CustomerTicketCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param string $status
     * @param int $userId
     * @param string $shoppingCartAmount
     * @param string $limit
     * @return mixed
     */
    public function userTickets(string $status,int $userId,string $shoppingCartAmount) {

        if ($status == 'unavailable'){
            $status = CustomerTicketCard::STATUS_OFF;
        }elseif ($status == 'available'){
            $status = CustomerTicketCard::STATUS_ON;
        }elseif ($status == 'already_used'){
            $status = CustomerTicketCard::STATUS_USE;
        }elseif ($status == 'be_overdue'){
            $status = CustomerTicketCard::STATUS_EXPIRE;
        }

        $this->scopeQuery(function (CustomerTicketCard $customerTicketCard) use($status, $userId, $shoppingCartAmount) {
            return $customerTicketCard
                ->where(['customer_id'=>$userId, 'status'=>$status])
                ->whereHas('card', function ($query) use($shoppingCartAmount){
                    $query->where('card_info->least_cost', '<=', $shoppingCartAmount)
                        ->orWhereNull('card_info->least_cost');
                })
                ->groupBy('card_id');
        });
        return $this->paginate();
    }

    /**
     * @param int $userId
     * @param string $status
     * @return mixed
     */
    public function customerTicketCards (int $userId,string $status)
    {
        $this->scopeQuery(function (CustomerTicketCard $customerTicketCard) use($userId,$status) {
            return $customerTicketCard
                ->where(['customer_id'=>$userId, 'customer_ticket_cards.status'=>$status])
                ->join('cards', 'customer_ticket_cards.card_id', '=', 'cards.card_id')
                ->with(['card' => function ($card) use ($userId){
                    return $card->withCount(['records as record_count' => function ($records) use ($userId) {
                        return $records->where('customer_id' , $userId);
                    }]);
                }])
                ->groupBy('customer_ticket_cards.card_id');
        });
        return $this->paginate();
    }
    
}
