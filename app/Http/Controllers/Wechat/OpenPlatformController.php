<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Overtrue\LaravelWeChat\Controllers\OpenPlatformController as Controller;

class OpenPlatformController extends Controller
{
    //
    protected $openPlatform = null;

    public function __construct()
    {
        //监听事件
    }

    protected function focus()
    {
        //
        $user = null;
        Event::dispatch(SEND_FOCUS_CARD_EVENT, $user);
    }
}
