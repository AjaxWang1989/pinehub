<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;

class MessageServerController extends Controller
{
    //
    public function serve($server = 'wechat')
    {
        return $server === 'wechat' ? $this->wechat->officeAccountServerHandle() :
            $this->wechat->miniProgramServerHandle();
    }
}
