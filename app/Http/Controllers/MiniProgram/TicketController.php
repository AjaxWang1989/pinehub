<?php

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Card;
use App\Entities\CustomerTicketCard;
use App\Entities\Order;
use App\Repositories\AppRepository;
use App\Repositories\CardRepository;
use App\Services\AppManager;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\TicketTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
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

    // 通用优惠券
    public function tickets(Request $request)
    {
        $tickets = $this->cardRepository->scopeQuery(function (Card $card) {
            return $card->whereNotIn('id', function (Builder $query) {
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

    public function userReceiveTicket(int $cardId)
    {
        /** @var Card $ticket */
        $appId = app(AppManager::class)->getAppId();
        $ticket = $this->cardRepository->scopeQuery(function (Card $card) use ($appId) {
            return $card->whereAppId($appId);
        })->find($cardId);
        $customer = $this->mpUser();
        $count = $customer->ticketRecords()->where('card_id', $ticket->cardId)->count();
        if (isset($ticket->cardInfo['base_info']['get_limit']) && $ticket->cardInfo['base_info']['get_limit'] > 0
            && $ticket->cardInfo['base_info']['get_limit'] <= $count) {
            throw new ModelNotFoundException('此优惠券不可以重复领取');
        }
        if ($ticket->userGetCount < $ticket->cardInfo['base_info']['sku']['quantity']) {
            $record = new CustomerTicketCard();
            $record->cardId = $ticket->cardId;
            $record->customerId = $customer->id;
            $record->appId = $appId;
            $record->openId = $customer->platformOpenId;
            $record->unionId = $customer->unionId;
            if ($ticket->cardInfo) {
                if ($ticket->cardInfo['base_info'] && $ticket->cardInfo['base_info']['date_info']) {
                    $dateInfo = $ticket->cardInfo['base_info']['date_info'];
                    if ($dateInfo['type'] === DATE_TYPE_FIX_TERM) {
                        $record->beginAt = Carbon::now()->addDay($dateInfo['fixed_begin_term']);
                        $record->endAt = $record->beginAt->copy()->addDay($dateInfo['fixed_term']);
                    } elseif ($dateInfo['type'] === DATE_TYPE_FIX_TIME_RANGE) {
                        $record->beginAt = Carbon::createFromTimestamp($dateInfo['begin_timestamp']);
                        $record->endAt = Carbon::createFromTimestamp($dateInfo['end_timestamp']);
                    } else {
                        $record->beginAt = $ticket->beginAt;
                        $record->endAt = $ticket->endAt;
                    }
                } else {
                    $record->beginAt = $ticket->beginAt;
                    $record->endAt = $ticket->endAt;
                }
            } else {
                $record->beginAt = $ticket->beginAt;
                $record->endAt = $ticket->endAt;
            }
            if ($record->beginAt->diffInRealSeconds(Carbon::now()) > 1) {
                $record->status = CustomerTicketCard::STATUS_OFF;
            } else {
                $record->status = CustomerTicketCard::STATUS_ON;
                $record->active = CustomerTicketCard::ACTIVE_ON;
            }
            $record->save();
            return $this->response()->item($record, new CustomerTicketCardTransformer());
        }

        throw new ModelNotFoundException('优惠券已领取完');
    }

    // 条件优惠券
    public function ticketsUserReceivable(Request $request, int $orderId)
    {
        $order = Order::query()->findOrFail($orderId);

        $tickets = $this->cardRepository->scopeQuery(function (Card $card) {
            return $card->has('condition')->with('condition')
                ->whereNotIn('id', function (Builder $query) {
                    $query->from('cards')->select(DB::raw('cards.id  as id'))
                        ->join('customer_ticket_cards', 'cards.card_id', '=', 'customer_ticket_cards.card_id')
                        ->where('customer_ticket_cards.customer_id', $this->mpUser()->id);
                });
        })->all();

        $availableTickets = [];
        /** @var Card $ticket */
        foreach ($tickets as $ticket) {
            $condition = $ticket->condition;
            // 支付可领取
            if (!$condition->paid) {
                continue;
            }
            if (isset($condition->valid_obj)) {
                // 未指定店铺 或者 指定店铺与订单店铺一致
                if (isset($condition->valid_obj['shops'])) {
                    $shops = (array)$condition->valid_obj['shops'];
                    if (count($shops) && !in_array($order->shopId, $shops)) {
                        continue;
                    }
                }
                // 未指定商品 或者 指定商品与订单商品一致
                $order_merchandises = $order->orderItems()->pluck('merchandise_id');
                if (isset($condition->valid_obj['merchandises'])) {
                    $merchandises = (array)$condition->valid_obj['merchandises'];
                    if (count($merchandises) && !count(array_intersect($merchandises, $order_merchandises->toArray()))) {
                        continue;
                    }
                }
                // 未指定可使用用户 或者 指定可使用用户与下单用户一致
                if (isset($condition->valid_obj['customers'])) {
                    $customers = (array)$condition->valid_obj['customers'];
                    if (count($customers) && !in_array($order->customerId, $customers)) {
                        continue;
                    }
                }
            }
            // 订单实际支付金额满足优惠券可领取门槛
            if ($order->paymentAmount >= $condition->pre_payment_amount) {
                $availableTickets[] = $ticket;
                continue;
            }
            $loopResults = Order::query()->where('customer_id', $order->customerId)
                ->where('created_at', '>=', Carbon::now()->subDays($condition->loop))
                ->select(DB::raw('count(*) as order_num,sum(payment_amount) as payment_amount_total'))
                ->first()->toArray();
            foreach ($loopResults as $key => $item) {
                $$key = $item;
            }
            // 周期内订单数满足 或者 周期内消费总额满足
            if ($condition->loop_order_num && $condition->loop_order_num <= $order_num ||
                $condition->loop_order_amount && $condition->loop_order_amount < $payment_amount_total) {
                $availableTickets[] = $ticket;
            }
        };

        $paginator = new LengthAwarePaginator($availableTickets, count($availableTickets), $request->input('limit', PAGE_LIMIT), $request->input('page', 1));

        return $this->response()->paginator($paginator, new TicketTransformer());
    }
}
