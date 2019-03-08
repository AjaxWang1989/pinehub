<?php

namespace App\Repositories;

use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
use App\Entities\Order;
use App\Entities\Ticket;
use App\Services\AppManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class TicketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketRepositoryEloquent extends CardRepositoryEloquent implements TicketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ticket::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
//        Ticket::creating(function (Ticket &$ticket) {
//            if($ticket->ticketType)
//                $ticket->cardType = $ticket->ticketType;
//            if($ticket->ticketInfo)
//                $ticket->cardInfo = $ticket->ticketInfo;
//            unset($ticket->ticketType, $ticket->ticketType);
//        });
    }

    public function getConditionalTickets(Order $order)
    {
        $orderRepository = app(OrderRepository::class);
        /** @var Ticket[] $tickets */
        $tickets = $this->scopeQuery(function (Ticket $ticket) {
            return $ticket->has('condition')->with('condition')
                ->whereNotIn('id', function (Builder $query) {
                    $query->from('cards')->select(DB::raw('cards.id  as id'))
                        ->join('customer_ticket_cards', 'cards.card_id', '=', 'customer_ticket_cards.card_id')
                        ->where('customer_ticket_cards.customer_id', $this->mpUser()->id);
                });
        })->all();

        $availableTickets = [];
        foreach ($tickets as $ticket) {
            $condition = $ticket->condition;
            // 支付可领取
            if (!$condition->paid) {
                continue;
            }
            if (isset($condition->validObj)) {
                // 未指定店铺 或者 指定店铺与订单店铺一致
                if (!empty($condition->validObj['shops']) && !in_array($order->shopId, (array)$condition->validObj['shops'])) {
                    continue;
                }
                // 未指定商品 或者 指定商品与订单商品一致
                $order_merchandises = $order->orderItems()->pluck('merchandise_id');
                if (!empty($condition->validObj['merchandises']) && !$order_merchandises->intersect((array)$condition->validObj['merchandises'])->count()) {
                    continue;
                }
                // 未指定可使用用户 或者 指定可使用用户与下单用户一致
                if (!empty($condition->validObj['customers']) && !in_array($order->customerId, (array)$condition->validObj['customers'])) {
                    continue;
                }
            }
            // 订单实际支付金额满足优惠券可领取门槛
            if ($order->paymentAmount >= $condition->prePaymentAmount) {
                $availableTickets[] = $ticket;
                continue;
            }

            $loopResults = $orderRepository->scopeQuery(function (Order $query) use ($condition, $order) {
                return $query->where('customer_id', $order->customerId)
                    ->where('created_at', '>=', Carbon::now()->subDays($condition->loop))
                    ->select(DB::raw('count(*) as order_num,sum(payment_amount) as payment_amount_total'));
            })->first()->toArray();

            // 周期内订单数满足 或者 周期内消费总额满足
            if ($condition->loopOrderNum && $condition->loopOrderNum <= $loopResults['order_num'] ||
                $condition->loopOrderAmount && $condition->loopOrderAmount < $loopResults['payment_amount_total']) {
                $availableTickets[] = $ticket;
            }
        };

        return $availableTickets;
    }

    public function receiveTicket(Customer $customer, Ticket $ticket)
    {
        $appId = app(AppManager::class)->getAppId();

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
            return $record;
        }

        throw new ModelNotFoundException('优惠券已领取完');
    }

}
