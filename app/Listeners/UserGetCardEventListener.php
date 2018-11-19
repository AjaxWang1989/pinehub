<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
use App\Entities\MemberCard;
use App\Events\UserGetCardEvent;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserGetCardEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserGetCardEvent  $event
     * @return void
     */
    public function handle(UserGetCardEvent $event)
    {
        //
        $payload = $event->payload;
        if($payload) {
            $card = Card::whereCardId($payload['CardId'])->first();
            $customer = Customer::with('user')
                ->wherePlatformOpenId($event->getFromUserName())
                ->first();

            switch ($card->cardType){
                case Card::MEMBER_CARD: {
                    if($customer->user) {
                        $memberCard = new MemberCard();
                        $memberCard->cardId = $card->id;
                        $memberCard->userId = $customer->userId;
                        $memberCard->appId = $customer->appId;
                        $memberCard->cardCode = $event->getUserCardCode();
                        $memberCard->unionId = $event->getUnionId();
                        $memberCard->outerStr = $event->getOuterStr();
                        $memberCard->isGiveByFriend = $event->getIsGiveByFriend();
                        $memberCard->friendOpenId = $event->getFriendUserName();
                        $memberCard->active = $card->cardInfo['auto_activate'];
                        $memberCard->bonus = $card->cardInfo['bonus_rule']['init_increase_bonus'];

                        if($memberCard->card->cardInfo['base_info']['sku']['quantity'] > 0){
                            $memberCard->card->cardInfo['base_info']['sku']['quantity'] -= 1;
                            $memberCard->card->save();
                        }

                        $memberCard->save();
                    }

                    break;
                }
                case Card::GROUPON:
                case Card::GIFT:
                case Card::COUPON_CARD:
                case Card::DISCOUNT: {
                    $ticketCard = new CustomerTicketCard();
                    $dateInfo = $card->cardInfo['base_info']['date_info'];
                    switch ($dateInfo['type']) {
                        case 'DATE_TYPE_FIX_TIME_RANGE': {
                            $ticketCard->beginAt = Carbon::createFromTimestamp($dateInfo['begin_timestamp'], config('app.timezone'));
                            $ticketCard->endAt = Carbon::createFromTimestamp($dateInfo['end_timestamp'], config('app.timezone'));
                            break;
                        }
                        case 'DATE_TYPE_FIX_TERM': {
                            $ticketCard->beginAt = Carbon::now(config('app.timezone'))->addDay($dateInfo['fixed_begin_term']);
                            $ticketCard->endAt = Carbon::now(config('app.timezone'))->addDay($dateInfo['fixed_begin_term'] + $dateInfo['fixed_term']);
                            break;
                        }
                    }
                    if($ticketCard->beginAt->timestamp <= time()) {
                        $ticketCard->status = CustomerTicketCard::STATUS_ON;
                    }
                    $ticketCard->cardId = $card->id;
                    $ticketCard->customerId = $customer->id;
                    $ticketCard->cardCode = $event->getUserCardCode();
                    $ticketCard->appId = $customer->appId;
                    $ticketCard->unionId = $event->getUnionId();
                    $ticketCard->outerStr = $event->getOuterStr();
                    $ticketCard->isGiveByFriend = $event->getIsGiveByFriend();
                    $ticketCard->friendOpenId = $event->getFriendUserName();
                    $ticketCard->active = true;
                    if($ticketCard->card->cardInfo['base_info']['sku']['quantity'] > 0){
                        $ticketCard->card->cardInfo['base_info']['sku']['quantity'] -= 1;
                        $ticketCard->card->save();
                    }
                    $ticketCard->save();
                }
            }
        }
    }
}
