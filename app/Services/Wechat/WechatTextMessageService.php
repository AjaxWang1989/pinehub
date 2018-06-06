<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/5
 * Time: 下午2:16
 */

namespace App\Services\Wechat;


use App\Services\Wechat\Messages\TextMessage;

class WechatTextMessageService implements InterfaceServiceHandler
{
    protected $server = null;

    public function __construct()
    {
        $this->server = app('wechat')->officeAccountServer();
        $this->setListener();
    }

    public function handle()
    {
        list($to, $from,  $createTime, $message) = func_get_args();
        // TODO: Implement handle() method.
        $this->server->dispatch(WECHAT_TEXT_MESSAGE, new TextMessage($to, $from, $createTime, $message));
    }

    protected function setListener()
    {
        $this->server->observe(WECHAT_TEXT_MESSAGE, function (TextMessage $message){

            $this->server->serve()->setContent($message)->send();
        });
    }

    protected function searchKeyWordMessage($message)
    {

    }
}