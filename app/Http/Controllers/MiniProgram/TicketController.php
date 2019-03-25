<?php

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Card;
use App\Repositories\AppRepository;
use App\Repositories\TicketRepository;
use App\Services\AppManager;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\TicketTransformer;
use Dingo\Api\Http\Request;
use InvalidArgumentException;

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

    // 获取优惠券
    public function tickets(Request $request)
    {
        $scenario = (int)$request->input('scenario', SCENARIO_ALL_NUM);// 默认通用场景

        if (!in_array($scenario, array_keys(TICKET_SCENARIOS))) {
            throw new InvalidArgumentException('场景参数错误');
        }

        $tickets = $this->ticketRepository->getTickets($scenario);

        return $this->response()->paginator($tickets, new TicketTransformer());
    }

    // 领取优惠券
    public function userReceiveTicket(int $cardId)
    {
        $appId = app(AppManager::class)->getAppId();

        /** @var Card $ticket */
        $ticket = $this->ticketRepository->scopeQuery(function (Card $card) use ($appId) {
            return $card->whereAppId($appId);
        })->find($cardId);

        $customer = $this->mpUser();

        $record = $this->ticketRepository->receiveTicket($customer, $ticket);

        return $this->response()->item($record, new CustomerTicketCardTransformer());
    }
}
