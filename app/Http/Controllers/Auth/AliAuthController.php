<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AliAuthController extends Controller
{
    //
    public function oauth2(Request $request)
    {
        $authCode = $request->input('auth_code', null);
        $redirect = $request->input('redirect_uri', null);
        Log::debug('ali auth code '.$authCode);
        $token = app('ali.oauth.token')->charge(['grant_type' => 'authorization_code', 'code' => $authCode]);
        Log::debug('ali token', $token);
        return view('404');
    }
}
