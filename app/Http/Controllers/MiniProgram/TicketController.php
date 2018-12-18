<?php

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Card;
use App\Entities\CustomerTicketCard;
use App\Repositories\AppRepository;
use App\Repositories\CardRepository;
use App\Services\AppManager;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\TicketTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * @var CardRepository
     * */
    protected $cardRepository = null;
    public function __construct(Request $request, AppRepository $appRepository, CardRepository $cardRepository)
    {
        parent::__construct($request, $appRepository);
        $this->cardRepository = $cardRepository;
    }

    public function tickets (Request $request)
    {
        $tickets = $this->cardRepository->scopeQuery(function (Card $card) {
            return $card->whereNotIn('id', function (Builder $query) {
                $query->select(DB::raw('cards.id  as id'))
                    ->join('customer_ticket_cards', 'customer_ticket_cards.card_id', '=', 'id')
                ->where('customer_ticket_cards.customer_id', $this->mpUser()->id);
            })->whereAppId(app(AppManager::class)->getAppId())
                ->where(DB::raw('(issue_count - user_get_count)'), '>', 0);
        })->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($tickets, new TicketTransformer());
    }

    public function userReceiveTicket(int $cardId)
    {
        /** @var Card $ticket */
        $appId = app(AppManager::class)->getAppId();
        $ticket = $this->cardRepository->scopeQuery(function (Card $card) use($appId){
            return $card->whereAppId($appId);
        })->find($cardId);
        $customer = $this->mpUser();
        $record = new CustomerTicketCard();
        $record->cardId = $ticket->cardId;
        $record->status = CustomerTicketCard::STATUS_ON;
        $record->customerId = $customer->id;
        $record->appId = $appId;
        $record->openId = $customer->platformOpenId;
        $record->unionId = $customer->unionId;
        $record->active = CustomerTicketCard::ACTIVE_ON;
        $record->beginAt = $ticket->beginAt;
        $record->endAt = $ticket->endAt;
        $record->save();
        return $this->response()->item($record, new CustomerTicketCardTransformer());
    }
}
