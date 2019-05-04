<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午4:30
 */

namespace App\Notifications\Channels;


use App\Notifications\Wechat\WechatTemplateMessageInterface;
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
     * @return mixed
     * @throws
     */
    public function send(Notifiable $notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('Wechat', $notification)) {
            return;
        }
        return with($notification, function (WechatTemplateMessageInterface $notification) use($notifiable) {
            $message = $notification->toWechatTemplateMessage( $notifiable );
            return $this->client->send($message);
        });
    }

}