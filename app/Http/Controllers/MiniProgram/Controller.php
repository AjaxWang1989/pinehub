<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 1:52
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\MpUser;
use App\Http\Controllers\Controller as BaseController;
use App\Repositories\AppRepository;
use App\Services\AppManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as LRequest;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    protected  $appRepository = null;
    public function __construct(Request $request, AppRepository $appRepository)
    {
        date_default_timezone_set("Asia/Shanghai");
        parent::__construct();
        $this->appRepository = $appRepository;
        $accessToken = $request->input('access_token', null);
        Log::info('access token '.$accessToken.' app id '.Cache::get($accessToken), $request->all());
        if($accessToken) {
            $appId = Cache::get($accessToken);
            $app = $this->appRepository->find($appId);
        }

        $user = Auth::user();

        if($user) {
            $app = $user->app;
        }
        if(isset($app)) {
            app(AppManager::class)->setCurrentApp($app);
        }
    }

    public function session() {
        $accessToken = LRequest::input('access_token', null);
        $session = [];
        Log::info('!!!!!!!!!!!!!!!! session token !!!!!!!!!!!! '.$accessToken);
        if($accessToken){
            $session = Cache::get($accessToken.'_session');
        }else{
            $user  = Auth::user();
            if($user) {
                with($user, function (MpUser $user) use(&$session){
                    $session['session_key'] = $user->sessionKey;
                    $session['openid'] = $user->platformOpenId;
                    return $user;
                });
            }else{
                $session = null;
            }

        }
        return $session;
    }

    /**
     * @return MpUser
     * */
    public function mpUser() {
        return $this->user();
    }
}