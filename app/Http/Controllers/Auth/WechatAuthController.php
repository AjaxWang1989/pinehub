<?php

namespace App\Http\Controllers\Auth;

use function GuzzleHttp\Psr7\parse_query;
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
        $count = $request->getSession()->get('count', 0);
        if($count){
            $request->getSession()->put('count', ++ $count);
        }
        \Log::debug('count = '.$count);
        $user = app('wechat.official_account.default')
            ->oauth->setRequest($request)->user();
        $openId = $user->getId();
        $redirect = $request->input('redirect_uri', null);
        $session = $request->getSession();
        $session->push('open_id', $openId);
        if($redirect) {
            if(count(parse_query($redirect)) > 0){
                $append = "&open_id={$openId}";
            }else{
                $append = "?open_id={$openId}";
            }
            return redirect("{$redirect}{$append}");
        }
        return null;
    }

    public function miniProgramAuth()
    {

    }
}
