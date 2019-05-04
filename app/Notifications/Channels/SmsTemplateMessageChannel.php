<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午7:12
 */

namespace App\Notifications\Channels;


use App\Notifications\Sms\SmsTemplateMessageInterface;

class SmsTemplateMessageChannel
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
    public function __construct($client)
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
        return with($notification, function (SmsTemplateMessageInterface $notification) use($notifiable) {
            $message = $notification->toSmsTemplateMessage( $notifiable );
            return $this->client->send($message);
        });
    }
}