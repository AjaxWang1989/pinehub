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
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    protected  $appRepository = null;
    public function __construct(Request $request, AppRepository $appRepository)
    {
        parent::__construct();
        $this->appRepository = $appRepository;
        $accessToken = $request->input('access_token', null);

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
}