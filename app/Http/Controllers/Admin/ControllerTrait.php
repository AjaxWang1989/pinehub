<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/5
 * Time: 下午3:08
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Administrator;
use App\Repositories\AppRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;

trait ControllerTrait
{
    public function parseApp(Request $request, AppRepository $repository)
    {
        $appId = $request->header('project_id', null);
        $appId = $appId ? $appId : $request->query('project_id', null);
        $appId = $appId ? $appId : (app()->has('session') ? app()->make('session')->get('project_id') : null);
        $currentApp = $appId ? $repository->find($appId) : null;
        if($currentApp)
            app(AppManager::class)->setCurrentApp($currentApp);
    }

    /**
     * @return Administrator
     * */
    public function administrator() {
        return $this->user();
    }
}