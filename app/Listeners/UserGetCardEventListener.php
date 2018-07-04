<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
use App\Entities\MemberCard;
use App\Events\UserGetCardEvent;
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
            $customer = Customer::with('user')->wherePlatformOpenId($payload['FromUserName'])->first();
            switch ($card->cardType){
                case Card::MEMBER_CARD: {
                    if($customer->user) {
                        $memberCard = new MemberCard();
                        $memberCard->cardId = $card->id;
                        $memberCard->userId = $customer->userId;
                        $memberCard->appId = $customer->appId;
                        $memberCard->cardCode = $payload['UserCardCode'];
                        $memberCard->unionId = $payload['UnionId'];
                        $memberCard->outerStr = $payload['OuterStr'];
                        $memberCard->isGiveByFriend = $payload['IsGiveByFriend'];
                        $memberCard->friendOpenId = $payload['FriendUserName'];
                        $memberCard->active = false;
                        $memberCard->save();
                    }

                    break;
                }
                case Card::GROUPON:
                case Card::GIFT:
                case Card::COUPON_CARD:
                case Card::DISCOUNT: {
                    $ticketCard = new CustomerTicketCard();
                    $ticketCard->cardId = $card->id;
                    $ticketCard->customerId = $customer->id;
                    $ticketCard->cardCode = $payload['UserCardCode'];
                    $ticketCard->appId = $customer->appId;
                    $ticketCard->used = false;
                    $ticketCard->save();
                }
            }
        }
    }
}
