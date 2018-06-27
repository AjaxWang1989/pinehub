<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;

class OpenPlatformController extends Controller
{
    //
    /**
     * @var OpenPlatform
     * */
    protected $openPlatform = null;

    public function __construct()
    {
        $this->openPlatform = app('wechat')->openPlatform();
    }

    public function auth2(Request $request)
    {
        $scope = $request->input('scope', null);
        $appId = $request->input('app_id', null);
        switch($scope) {
            case USER_AUTH_BASE:{
                $accessToken = app('wechat')->openPlatformOfficialAccountAccessToken($appId);
                break;
            }
            case USER_AUTH_INFO: {
                break;
            }
        }
    }
}
