<?php

namespace App\Http\Controllers\Auth;

use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class AliAuthController extends Controller
{
    //
    public function oauth2(Request $request)
    {
        $redirect = $request->input('redirect_uri', null);
        if(($token = $request->getSession()->get('ali.oauth.token')) && isset($token['user_id'])) {
            Log::debug('session cache token ', $token);
        }else{
            $authCode = $request->input('auth_code', null);
            $token = app('ali.oauth.token')->charge(['grant_type' => 'authorization_code', 'code' => $authCode])->getToken();
            $request->getSession()->push('ali.oauth.token', $token);
        }

        if($redirect) {
            if(count(parse_query($redirect)) > 0){
                $append = "&buyer_id={$token['user_id']}";
            }else{
                $append = "?buyer_id={$token['user_id']}";
            }
            return redirect("{$redirect}{$append}");
        }

        return view('404');
    }
}
