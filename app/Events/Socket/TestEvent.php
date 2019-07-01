<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/6/28
 * Time: 11:12 AM
 */


namespace App\Events\Socket;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{

    protected $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = [
            'payload' => [
                'test' => 'test'
            ],
            'message' => 'another'
        ];
    }

    public function broadcastOn()
    {

        return new Channel('usr');
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return json_encode([
            'data' => $this->data,
            'channel' => $this->broadcastOn()
        ]);
    }
}