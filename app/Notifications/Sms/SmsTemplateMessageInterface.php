<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午7:13
 */

namespace App\Notifications\Sms;


use Illuminate\Notifications\Notifiable;

interface SmsTemplateMessageInterface
{
    public function toSmsTemplateMessage(Notifiable $notifiable);
}