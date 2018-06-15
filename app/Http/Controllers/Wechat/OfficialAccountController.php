<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request as DingoRequest;

class OfficialAccountController extends Controller
{
    //
    protected $officialAccount = null;

    public function __construct()
    {
        $this->officialAccount = app('wechat')->officeAccount();
    }

    public function create(DingoRequest $request)
    {
        $this->officialAccount->oauth;
    }
}
