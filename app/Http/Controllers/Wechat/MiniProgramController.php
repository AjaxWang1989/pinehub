<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MiniProgramController extends Controller
{
    //
    protected $miniProgram = null;

    public function __construct()
    {
        $this->miniProgram = app('wechat')->miniProgram();
    }

    public function card() {
        app('wechat')->officeAccount()->card->jssdk->assign([]);
    }
}
