<?php

namespace App\Repositories;

use App\Entities\Card;
use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
use App\Entities\Order;
use App\Entities\Ticket;
use App\Services\AppManager;
use Carbon\Carbon;
use Dingo\Api\Auth\Auth;
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
    }

    public function getTickets($scenario)
    {
        $scenario = (array)$scenario;

        $order = null;
        if ($orderId = request()->input('order_id', null)) {
            /** @var Order $order */
            $order = app(OrderRepository::class)->find($orderId);
        }

        $tickets = $this->scopeQuery(function (Ticket $ticket) use ($scenario, $order) {
            $currentMpUser = app(Auth::class)->user();
//            $currentMpUser = User::find(4295);
            return $ticket->whereNotIn('cards.id', function (Builder $query) use ($currentMpUser) {
                $query->from('cards')->select(DB::raw('cards.id  as id'))
                    ->join('customer_ticket_cards', 'cards.card_id', '=', 'customer_ticket_cards.card_id')
                    ->where('customer_ticket_cards.customer_id', $currentMpUser->id);
            })->whereHas('putCondition', function ($query) use ($currentMpUser, $scenario, $order) {
                $query->where(function ($query) use ($currentMpUser, $scenario, $order) {
                    $query->where(function ($query) use ($currentMpUser, $scenario) {
                        $query->where(function ($query) use ($currentMpUser, $scenario) {// 适用场景
                            $query->jsonSearch('show', $scenario);
                        })->where(function ($query) use ($currentMpUser) {// 适用性别
                            $query->where('valid_obj->customers->sex', 'ALL')
                                ->orWhere('valid_obj->customers->sex', $currentMpUser->sex);
                        })->where(function ($query) use ($currentMpUser) {// 适用用户
                            $query->jsonSearch('valid_obj->customers->tags', $currentMpUser->tags);
                        });
                    })->whereExists(function ($query) use ($currentMpUser) {// 订单loop
                        $query->select(DB::raw(1))
                            ->from('orders')
                            ->whereRaw("orders.customer_id = {$currentMpUser->id}")
                            ->where(function ($query) {
                                $query->where('loop', 0)
                                    ->orWhere(function ($query) {
                                        $query->whereRaw("paid_at >= DATE_SUB(now(),INTERVAL card_conditions.`loop` DAY)")
                                            ->havingRaw("count(*) >= loop_order_num and sum(payment_amount) >= loop_order_amount");
                                    });
                            });
                    });
                    if (!is_null($order)) {// 单笔订单
                        $query->where('pre_payment_amount', '<=', $order->paymentAmount);
                    }
                });
            })
//                ->whereAppId('2018090423350000')
                ->whereAppId(app(AppManager::class)->getAppId())
                ->whereStatus(Card::STATUS_ON)
                ->where(DB::raw('(issue_count - user_get_count)'), '>', 0)
                ->orderBy('cards.created_at', 'desc')
                ->orderBy('cards.updated_at', 'desc');
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $tickets;
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
                        $record->beginAt = Carbon::now()->addDay($dateInfo['fixed_begin_term'])->startOfDay();
                        $record->endAt = $record->beginAt->copy()->addDay($dateInfo['fixed_term'])->endOfDay();
                    } elseif ($dateInfo['type'] === DATE_TYPE_FIX_TIME_RANGE) {
                        $record->beginAt = Carbon::createFromTimestamp($dateInfo['begin_timestamp'])->startOfDay();
                        $record->endAt = Carbon::createFromTimestamp($dateInfo['end_timestamp'])->startOfDay();
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

    public function getPromoteMiniCode(Ticket $ticket)
    {
        return app('wechat')->miniProgram()->app_code->getUnlimit($ticket->id);
    }
}
