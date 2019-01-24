<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 1:52
 */

namespace App\Http\Controllers\Merchant;

use App\Entities\MpUser;
use App\Entities\ShopManager;
use App\Http\Controllers\Controller as BaseController;
use App\Repositories\AppRepository;
use App\Repositories\ShopManagerRepository;
use App\Services\AppManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as LRequest;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    protected  $appRepository = null;
    protected $shopManagerRepository = null;
    protected $shopManager = null;
    public function __construct(Request $request, AppRepository $appRepository, ShopManagerRepository $shopManagerRepository)
    {
        date_default_timezone_set("Asia/Shanghai");
        parent::__construct();
        $this->appRepository = $appRepository;
        $accessToken = $request->input('access_token', null);
        if($accessToken) {
            $appId = Cache::get($accessToken);
            $app = $this->appRepository->find($appId);
        }

        $this->shopManagerRepository = $shopManagerRepository;

        $this->shopManager = Auth::user();
        if($this->shopManager) {
            $app = $this->shopManager->app;
        }
        if(isset($app)) {
            app(AppManager::class)->setCurrentApp($app);
        }
    }
}