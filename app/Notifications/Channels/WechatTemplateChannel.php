<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午4:30
 */

namespace App\Notifications\Channels;


use EasyWeChat\OfficialAccount\TemplateMessage\Client as TemplateMessageClient;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class WechatTemplateChannel
{
    /**
     * The wechat template service client instance
     * @var TemplateMessageClient
     * */
    protected $client = null;

    /**
     * the wechat template message channel construct
     * @param TemplateMessageClient $client
     * */
    public function __construct(TemplateMessageClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  Notifiable  $notifiable
     * @param  Notification  $notification
     * @return boolean
     * @throws
     */
    public function send(Notifiable $notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('Wechat', $notification)) {
            return;
        }
        $message = $notification->toWechatTemplateMessage( $notifiable );
        $this->client->send($message);
        return true;
    }

}