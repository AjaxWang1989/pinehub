<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19
 * Time: 22:05
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Entities\Administrator;
use App\Repositories\AppRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;

class BackendServiceProvider extends ServiceProvider
{
    public function register() {
    }

    public function boot(Request $request, AppRepository $repository) {
        $appId = $request->header('ProjectId', null);
        $appId = $appId ? $appId : $request->query('ProjectId', null);
        $appId = $appId ? $appId : (app()->has('session') ? app()->make('session')->get('project_id') : null);
        $currentApp = $appId ? $repository->find($appId) : null;
        $appManager = app(AppManager::class);
        if($currentApp)
            $appManager->setCurrentApp($currentApp);
    }
}