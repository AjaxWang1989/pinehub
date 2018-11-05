<?php

namespace App\Providers;

use App\Entities\MpUser;
use App\Entities\WechatMenu;
use App\Events\CardCheckEvent;
use App\Events\CardPayOrderEvent;
use App\Events\CardSKURemindEvent;
use App\Events\MemberCardActiveEvent;
use App\Events\OrderScoreEvent;
use App\Events\SyncMemberCardInfoEvent;
use App\Events\SyncTicketCardInfoEvent;
use App\Events\UpdateMemberCardEvent;
use App\Events\UserCardPaidEvent;
use App\Events\UserConsumeCardEvent;
use App\Events\UserDelCardEvent;
use App\Events\UserEnterOfficialAccountFromCardEvent;
use App\Events\UserGetCardEvent;
use App\Events\UserSendCardEvent;
use App\Events\UserUseCardToPayEvent;
use App\Events\UserViewCardEvent;
use App\Events\WechatAuthAccessTokenRefreshEvent;
use App\Listeners\CardCheckEventListener;
use App\Listeners\CardPayOrderEventListener;
use App\Listeners\CardSKURemindEventListener;
use App\Listeners\MemberCardActiveEventListener;
use App\Listeners\OpenPlatformAuthorized;
use App\Listeners\OpenPlatformUnauthorized;
use App\Listeners\OrderScoreListener;
use App\Listeners\SyncMemberCardInfoEventListener;
use App\Listeners\SyncTicketCardInfoEventListener;
use App\Listeners\UpdateMemberCardListener;
use App\Listeners\UserCardPaidListener;
use App\Listeners\UserConsumeCardEventListener;
use App\Listeners\UserDelCardEventListener;
use App\Listeners\UserEnterOfficialAccountFromCardEventListener;
use App\Listeners\UserGetCardEventListener;
use App\Listeners\UserSendCardEventListener;
use App\Listeners\UserUseCardToPayEventListener;
use App\Listeners\UserViewMemberCardEventListener;
use App\Listeners\VerifyTicketRefreshEventListener;
use App\Listeners\WechatAuthAccessTokenRefreshListener;
use App\Observers\MpUserObserver;
use App\Observers\WechatMenuObserver;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Unauthorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\UpdateAuthorized;
use Overtrue\LaravelWeChat\Events\OpenPlatform\VerifyTicketRefreshed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        MpUser::observe(MpUserObserver::class);
        WechatMenu::observe(WechatMenuObserver::class);
        parent::boot();
    }
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
           OpenPlatformAuthorized::class
        ],
        VerifyTicketRefreshed::class =>[
            VerifyTicketRefreshEventListener::class
        ],
        SyncMemberCardInfoEvent::class => [
            SyncMemberCardInfoEventListener::class
        ],
        SyncTicketCardInfoEvent::class => [
            SyncTicketCardInfoEventListener::class
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
        UserViewCardEvent::class => [
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
        UserCardPaidEvent::class => [
            UserCardPaidListener::class
        ],
        UserDelCardEvent::class => [
            UserDelCardEventListener::class
        ],
        UserEnterOfficialAccountFromCardEvent::class => [
            UserEnterOfficialAccountFromCardEventListener::class
        ],
        WechatAuthAccessTokenRefreshEvent::class => [
            WechatAuthAccessTokenRefreshListener::class
        ],
        UpdateMemberCardEvent::class => [
            UpdateMemberCardListener::class
        ]
    ];
}
