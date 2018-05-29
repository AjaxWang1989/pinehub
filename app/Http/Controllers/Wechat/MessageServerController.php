<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;

class MessageServerController extends Controller
{
    protected $wechat = null;
    //
    public function __construct()
    {
        $this->wechat = app('wechat');
    }

    public function serve($server = 'wechat')
    {
        return $server === 'wechat' ? $this->wechat->officeAccountServerHandle() :
            $this->wechat->miniProgramServerHandle();
    }
}
