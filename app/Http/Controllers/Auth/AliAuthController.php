<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AliAuthController extends Controller
{
    //
    public function oauth2(Request $request)
    {
        $token = Session::get('ali.oauth.token', null);
        if($token){
            Log::debug('session ali.oauth.token', $token);
        }
        $authCode = $request->input('auth_code', null);
        $redirect = $request->input('redirect_uri', null);
        $token = app('ali.oauth.token')->charge(['grant_type' => 'authorization_code', 'code' => $authCode]);
        Session::put('ali.oauth.token', $token);
        return view('404');
    }
}
