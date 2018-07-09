<?php

namespace App\Providers;

use App\Events\CardCheckEvent;
use App\Events\CardPayOrderEvent;
use App\Events\CardSKURemindEvent;
use App\Events\MemberCardActiveEvent;
use App\Events\OrderScoreEvent;
use App\Events\SyncMemberCardInfoEvent;
use App\Events\SyncTicketCardInfoEvent;
use App\Events\UserConsumeCardEvent;
use App\Events\UserDelCardEvent;
use App\Events\UserEnterOfficialAccountFromCardEvent;
use App\Events\UserGetCardEvent;
use App\Events\UserSendCardEvent;
use App\Events\UserUseCardToPayEvent;
use App\Events\UserViewMemberCardEvent;
use App\Events\WechatAuthAccessTokenRefreshEvent;
use App\Listeners\CardCheckEventListener;
use App\Listeners\CardPayOrderEventListener;
use App\Listeners\CardSKURemindEventListener;
use App\Listeners\MemberCardActiveEventListener;
use App\Listeners\OpenPlatformAuthorized;
use App\Listeners\OpenPlatformUnauthorized;
use App\Listeners\OpenPlatformUpdateAuthorized;
use App\Listeners\OrderScoreListener;
use App\Listeners\SyncMemberCardInfoEventListener;
use App\Listeners\UserConsumeCardEventListener;
use App\Listeners\UserDelCardEventListener;
use App\Listeners\UserEnterOfficialAccountFromCardEventListener;
use App\Listeners\UserGetCardEventListener;
use App\Listeners\UserSendCardEventListener;
use App\Listeners\UserUseCardToPayEventListener;
use App\Listeners\UserViewMemberCardEventListener;
use App\Listeners\VerifyTicketRefreshEventListener;
use App\Listeners\WechatAuthAccessTokenRefreshListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Unauthorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\UpdateAuthorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\VerifyTicketRefreshed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderScoreEvent::class => [
            OrderScoreListener::class
        ],
        Authorized::class => [
            OpenPlatformAuthorized::class
        ],
        Unauthorized::class => [
            OpenPlatformUnauthorized::class
        ],
        UpdateAuthorized::class => [
            OpenPlatformUpdateAuthorized::class
        ],
        VerifyTicketRefreshed::class =>[
            VerifyTicketRefreshEventListener::class
        ],
        SyncMemberCardInfoEvent::class => [
            SyncMemberCardInfoEventListener::class
        ],
        SyncTicketCardInfoEvent::class => [
            SyncMemberCardInfoEventListener::class
        ],
        CardSKURemindEvent::class => [
            CardSKURemindEventListener::class
        ],
        CardCheckEvent::class => [
            CardCheckEventListener::class
        ],
        CardPayOrderEvent::class => [
            CardPayOrderEventListener::class
        ],
        UserGetCardEvent::class => [
            UserGetCardEventListener::class
        ],
        UserViewMemberCardEvent::class => [
            UserViewMemberCardEventListener::class
        ],
        MemberCardActiveEvent::class => [
            MemberCardActiveEventListener::class
        ],
        UserConsumeCardEvent::class => [
            UserConsumeCardEventListener::class
        ],
        UserSendCardEvent::class => [
            UserSendCardEventListener::class
        ],
        UserUseCardToPayEvent::class => [
            UserUseCardToPayEventListener::class
        ],
        UserDelCardEvent::class => [
            UserDelCardEventListener::class
        ],
        UserUseCardToPayEvent::class => [
            UserUseCardToPayEventListener::class
        ],
        UserEnterOfficialAccountFromCardEvent::class => [
            UserEnterOfficialAccountFromCardEventListener::class
        ],
        WechatAuthAccessTokenRefreshEvent::class => [
            WechatAuthAccessTokenRefreshListener::class
        ]
    ];
}
