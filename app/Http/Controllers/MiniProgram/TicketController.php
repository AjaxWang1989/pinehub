<?php

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Card;
use App\Entities\Ticket;
use App\Repositories\AppRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TicketRepository;
use App\Services\AppManager;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\TicketTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * @var TicketRepository
     * */
    protected $ticketRepository = null;

    public function __construct(Request $request, AppRepository $appRepository, ticketRepository $ticketRepository)
    {
        parent::__construct($request, $appRepository);
        $this->ticketRepository = $ticketRepository;
    }

    // 通用优惠券
    public function tickets(Request $request)
    {
        $tickets = $this->ticketRepository->scopeQuery(function (Ticket $ticket) {
            return $ticket->whereNotIn('id', function (Builder $query) {
                $query->from('cards')->select(DB::raw('cards.id  as id'))
                    ->join('customer_ticket_cards', 'cards.card_id', '=', 'customer_ticket_cards.card_id')
                    ->where('customer_ticket_cards.customer_id', $this->mpUser()->id);
            })->doesntHave('condition')
                ->whereAppId(app(AppManager::class)->getAppId())
                ->whereStatus(Card::STATUS_ON)
                ->where(DB::raw('(issue_count - user_get_count)'), '>', 0)
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'desc');
        })->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($tickets, new TicketTransformer());
    }

    // 领取优惠券
    public function userReceiveTicket(int $cardId)
    {
        /** @var Card $ticket */
        $appId = app(AppManager::class)->getAppId();

        $ticket = $this->ticketRepository->scopeQuery(function (Card $card) use ($appId) {
            return $card->whereAppId($appId);
        })->find($cardId);

        $customer = $this->mpUser();

        $record = $this->ticketRepository->receiveTicket($customer, $ticket);

        return $this->response()->item($record, new CustomerTicketCardTransformer());
    }

    // 条件优惠券
    public function ticketsUserReceivable(Request $request, TicketRepository $ticketRepository, OrderRepository $orderRepository, int $orderId)
    {
        $order = $orderRepository->find($orderId);

        $availableTickets = $ticketRepository->getConditionalTickets($order);

        $paginator = new LengthAwarePaginator($availableTickets, count($availableTickets), $request->input('limit', PAGE_LIMIT), $request->input('page', 1));

        return $this->response()->paginator($paginator, new TicketTransformer());
    }
}
