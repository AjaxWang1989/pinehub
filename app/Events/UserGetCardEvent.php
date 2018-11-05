<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;


/**
 * @method string getOuterStr()
 * @method boolean getIsGiveByFriend()
 * @method string getFriendUserName()
 * @method string getOldUserCardCode()
 * @method boolean getIsRestoreMemberCard()
 * */
class UserGetCardEvent extends CardEvent
{
    /**
     * Create a new event instance.
     *
     * @param $payload
     */
    public function __construct($payload)
    {
        //
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
