<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Overtrue\LaravelWeChat\Events\OpenPlatform\OpenPlatformEvent;
/**
 * @method string getToUserName()
 * @method string getFromUserName()
 * @method string getCreateTime()
 * @method string getMsgType()
 * @method string getEvent()
 * @method string getCardId()
 * @method string getUserCardCode()
 * @method string getPreAuthCode()
 * @method string getUnionId()
 */
class CardEvent extends OpenPlatformEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sysAppId = null;
    /**
     * Create a new event instance.
     *
     * @param $payload
     */
    public function __construct($payload)
    {
        //
        $payload = $payload['message'];
        $this->sysAppId = $payload['app_id'];
        parent::__construct($payload);
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
