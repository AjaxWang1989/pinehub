<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午6:55
 */

namespace App\Notifications\Wechat;


use Illuminate\Notifications\Notifiable;

interface WechatTemplateMessageInterface
{
    public function toWechatTemplateMessage(Notifiable $notifiable);
}