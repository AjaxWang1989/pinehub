<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatAuthController extends Controller
{
    //

    public function serve()
    {

    }

    public function oauth2(Request $request)
    {
        $user = app('wechat.official_account.default')
            ->oauth->setRequest($request)->user();
        $openId = $user->getId();
        $redirect = $request->input('redirect_uri', null);
        $session = app('session');
        $session->push('open_id', $openId);
        if($redirect) {
            return redirect("{$redirect}?open_id={$openId}");
        }
        return null;
    }

    public function miniProgramAuth()
    {

    }
}
