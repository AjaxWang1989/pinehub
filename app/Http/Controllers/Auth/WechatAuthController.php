<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\WechatUserRepositoryEloquent;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatAuthController extends Controller
{
    //
    protected $wechatUser = null;
    public function __construct(WechatUserRepositoryEloquent $eloquent)
    {
        $this->wechatUser = $eloquent;
    }

    public function serve()
    {

    }

    public function oauth2(Request $request)
    {
        $session = $request->getSession();
        $openId = null;
        $accessToken = $session->get('access_token', null);
        $scope = $request->get('scope', 'user_base');
        if(!$accessToken && $scope === USER_AUTH_BASE){
            $accessToken = app('wechat')
                ->officeAccount()
                ->oauth->setRequest($request)
                ->getAccessToken();
            $session->put('access_token', $accessToken->toArray());
        }
        if ($accessToken) {
            $openId = $accessToken['openid'];
        }

        $user = $session->get('wx_user', null);
        if(!$user && $scope === USER_AUTH_INFO) {
            $user = app('wechat')->officeAccount()
                ->oauth->setRequest($request)->user();
            $wxUser = $this->wechatUser->findWhere(['openid' => $user->getId()]);
            if($wxUser && $wxUser->count() > 0) {
                $wxUser = $wxUser->first();
                //更新信息
            }else{
                //新建用户，网页授权
            }
            $session->put('wx_user', $user->toArray());
        }

        if ($user) {
            $openId = $user['id'];
        }

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
