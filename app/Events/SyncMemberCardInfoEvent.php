<?php

namespace App\Events;

use App\Entities\Card;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Application as OpenPlatformMiniProgram;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application as OpenPlatformOfficialAccount;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SyncMemberCardInfoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $memberCard = null;

    /**
     * @var MiniProgram|OpenPlatformMiniProgram|OfficialAccount|OpenPlatformOfficialAccount
     * */
    public $wechat = null;

    /**
     * Create a new event instance.
     * @param Card $card
     * @param MiniProgram|OpenPlatformMiniProgram|OfficialAccount|OpenPlatformOfficialAccount
     * @return void
     */
    public function __construct(Card $card, $wechat = null)
    {
        //
        $this->memberCard = $card;
        $this->wechat = $wechat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
