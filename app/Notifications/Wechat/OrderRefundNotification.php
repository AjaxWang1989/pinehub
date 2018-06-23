<?php

namespace App\Notifications\Wechat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notifiable;

class OrderRefundNotification extends Notification implements WechatTemplateMessageInterface, ShouldQueue
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
        return ['mail'];
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
