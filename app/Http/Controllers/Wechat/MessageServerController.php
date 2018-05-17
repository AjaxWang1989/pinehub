<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;

class MessageServerController extends Controller
{
    protected $wechatApp = null;

    protected $miniApp = null;
    //
    public function __construct()
    {
        $this->wechatApp = app('wechat.official_account.default');
        $this->miniApp = app('wechat.mini_program.default');
    }

    public function serve($server = 'wechat')
    {
        $messageServer = ( $server === 'wechat' ? $this->wechatApp->server: $this->miniApp->server);
        $messageServer->push(function (){
            return "Welcome visit PineHub";
        });
        return $messageServer->serve();
    }
}
