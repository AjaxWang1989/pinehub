<?php

namespace App\Notifications\Wechat;

use App\Notifications\Messages\WechatTemplateMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCompletedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['wechatTemplateMessage'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  Notifiable  $notifiable
     * @return array
     */
    public function toWechatTemplateMessage(Notifiable $notifiable)
    {
        $templateMessage = new WechatTemplateMessage();
        $templateMessage->toUser = $notifiable;
        return [
            //
        ];
    }
}
