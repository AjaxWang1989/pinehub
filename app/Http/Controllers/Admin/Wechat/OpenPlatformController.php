<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Listeners\OpenPlatformAuthorized;
use App\Listeners\OpenPlatformUnauthorized;
use App\Listeners\OpenPlatformUpdateAuthorized;
use App\Transformers\WechatConfigTransformer;
use Dingo\Api\Routing\Helpers;
use EasyWeChat\OpenPlatform\Server\Guard;
use Event;
use Illuminate\Http\Request;
use Overtrue\LaravelWeChat\Controllers\OpenPlatformController as Controller;

class OpenPlatformController extends Controller
{
    use Helpers;
    //
    protected $openPlatform = null;

    public function __construct()
    {
        $this->openPlatform = app('wechat')->openPlatform();
        Event::listen(Guard::EVENT_AUTHORIZED, new OpenPlatformAuthorized());
        Event::listen(Guard::EVENT_UNAUTHORIZED, new OpenPlatformUnauthorized());
        Event::listen(Guard::EVENT_UPDATE_AUTHORIZED, new OpenPlatformUpdateAuthorized());
    }

    public function loginPageAuth(string $type = 'all', string $appId = null)
    {
        return app('wechat')->openPlatformComponentLoginPage($type, $appId);
    }

    public function loginPageAuthCallback(Request $request)
    {
        $authCode = $request->input('auth_code');
        $authorizer = app('wechat')->openPlatformAuthorizer($authCode);

    }

    /**
     *
     */
    public function apiAuthorizerToken()
    {
        $this->openPlatform->getAuthorizer();
    }

    public function bindToOpenPlatformAccount()
    {
        $wechat = app('current_wechat');
        $appId = $wechat->appId;
        $account = null;
        if($wechat->type === WECHAT_MINI_PROGRAM) {
            $account = $this->openPlatform->miniProgram($appId)->account;
        }elseif ($wechat->type === WECHAT_OFFICIAL_ACCOUNT) {
            $account = $this->openPlatform->officialAccount($appId)->account;
        }
        $result = $account->bindTo($this->openPlatform->config['app_id']);

        if($result['errcode'] === 0) {
            $wechat->bindOpenId = $this->openPlatform->config['app_id'];
            $wechat->save();
            return $this->response()->item($wechat, new WechatConfigTransformer());
        }else{
            return $this->response()->error($result['errmsg']);
        }
    }
}
