<?php

namespace App\Repositories;

use App\Entities\Card;
use App\Repositories\Traits\Destruct;
use App\Services\AppManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
     * @param float $shoppingCartAmount
     * @return mixed
     */
    public function userTickets(string $status, int $userId, float $shoppingCartAmount = null) {

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
                ->where(['customer_id' => $userId, 'status' => $status])
                ->whereHas('card', function (Builder $query) use($shoppingCartAmount){
                    if($shoppingCartAmount) {
                        $query->whereIn('card_type', [Card::DISCOUNT, Card::CASH])
                            ->fromSub(function (\Illuminate\Database\Query\Builder $query) {
                                return $query->select([DB::raw('CAST(card_info->least_cost as DECIMAL(12, 2)) as least_cost')])
                                    ->where('sub_cards.id = cards.id');
                            }, 'sub_cards')
                            ->whereRaw(DB::raw('sub_cards.least_cost <= ?'), (float)$shoppingCartAmount)
                            ->orWhereNull('sub_cards.least_cost');
                    }else{
                        $query->whereIn('card_type', [Card::DISCOUNT, Card::CASH]);
                    }
                    $query->where('app_id', app(AppManager::class)->getAppId());
                })->where('card_id','!=', '')
                ->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc');
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
                ->where(['customer_id'=>$userId, 'status'=>$status])
                ->groupBy('card_id');
        });
        return $this->paginate();
    }
    
}
