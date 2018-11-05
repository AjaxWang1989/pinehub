<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/11/5
 * Time: 10:47 PM
 */

namespace App\Services\Wechat;


use App\Events\CardCheckEvent;
use App\Events\CardPayOrderEvent;
use App\Events\CardSKURemindEvent;
use App\Events\MemberCardActiveEvent;
use App\Events\UpdateMemberCardEvent;
use App\Events\UserCardPaidEvent;
use App\Events\UserConsumeCardEvent;
use App\Events\UserDelCardEvent;
use App\Events\UserEnterOfficialAccountFromCardEvent;
use App\Events\UserGetCardEvent;
use App\Events\UserSendCardEvent;
use App\Events\UserViewCardEvent;
use App\Services\InterfaceServiceHandler;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\ServerGuard;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;


class CardEventHandler implements InterfaceServiceHandler
{
    public function handle(ServerGuard $server = null)
    {
        // TODO: Implement handle() method.

        try {
            $server->on(EVENT_CARD_PASS_CHECK, function ($payload) {
                Log::info('EVENT_CARD_PASS_CHECK');
                Event::fire(new CardCheckEvent($payload));
            });

            $server->on(EVENT_CARD_NOT_PASS_CHECK, function ($payload) {
                Log::info('EVENT_CARD_PASS_CHECK');
                Event::fire(new CardCheckEvent($payload));
            });

            $server->on(EVENT_CARD_SKU_REMIND, function ($payload) {
                Event::fire(new CardSKURemindEvent($payload));
            });

            $server->on(EVENT_USER_GET_CARD, function ($payload) {
                Log::info('EVENT_USER_GET_CARD');
                Event::fire(new UserGetCardEvent($payload));
            });

            $server->on(EVENT_USER_SEND_CARD, function ($payload) {
                Event::fire(new UserSendCardEvent($payload));
            });

            $server->on(EVENT_USER_CONSUME_CARD, function ($payload) {
                Event::fire(new UserConsumeCardEvent($payload));
            });

            $server->on(EVENT_USER_DELETE_CARD, function ($payload) {
                Event::fire(new UserDelCardEvent($payload));
            });

            $server->on(EVENT_USER_ENTER_SESSION, function ($payload) {
                Event::fire(new UserEnterOfficialAccountFromCardEvent($payload));
            });

            $server->on(EVENT_ACTIVE_MEMBER_CARD, function ($payload) {
                Event::fire(new MemberCardActiveEvent($payload));
            });

            $server->on(EVENT_CARD_PAY_ORDER, function ($payload) {
                Event::fire(new CardPayOrderEvent($payload));
            });

            $server->on(EVENT_USER_VIEW_CARD, function ($payload) {
                Event::fire(new UserViewCardEvent($payload));
            });

            $server->on(EVENT_UPDATE_MEMBER_CARD, function ($payload) {
                Event::fire(new UpdateMemberCardEvent($payload));
            });

            $server->on(EVENT_USER_PAID, function ($payload) {
                Event::fire(new UserCardPaidEvent($payload));
            });

        } catch (InvalidArgumentException $e) {

        }
    }
}