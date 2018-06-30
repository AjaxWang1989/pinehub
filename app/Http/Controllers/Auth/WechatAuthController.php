<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\WechatUserRepositoryEloquent;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WechatAuthController extends Controller
{
    //
    protected $wechatUser = null;
    public function __construct(WechatUserRepositoryEloquent $eloquent)
    {
        $this->wechatUser = $eloquent;
        $this->session = app('session');
    }

    public function serve()
    {

    }

    public function oauth2(Request $request)
    {
        $openId = null;
        $accessToken = null;
        $scope = $request->get('scope', USER_AUTH_BASE);

        if($scope === USER_AUTH_BASE) {
            $accessToken = app('wechat')->officialAccountAccessToken();
        }
        if ($accessToken) {
            $openId = $accessToken->openId;
        }
        $wechatUser = app('wechat')->officialAccountUser($openId);
        if ($wechatUser) {
            $openId = $wechatUser->openId;
        }
        $this->wechatUser->updateOrCreate(['open_id' => $wechatUser->openId], $wechatUser->toArray());
        $redirect = $request->input('redirect_uri', null);
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
