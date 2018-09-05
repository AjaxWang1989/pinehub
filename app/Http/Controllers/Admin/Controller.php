<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/5
 * Time: 下午3:08
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller as BaseController;
use App\Repositories\AppRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;

class Controller extends BaseController
{
    public function __construct(Request $request, AppRepository $repository)
    {
        $appId = $request->header('selected_appid', null);
        $appId = $appId ? $appId : $request->query('selected_appid', null);
        $appId = $appId ? $appId : (app()->has('session') ? app('session')->get('selected_appid') : null);
        $currentApp = $repository->find($appId);
        if($currentApp)
            app(AppManager::class)->setCurrentApp($currentApp);
    }
}