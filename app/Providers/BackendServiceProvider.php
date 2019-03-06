<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19
 * Time: 22:05
 */

namespace App\Providers;


use App\Repositories\AppRepository;
use App\Services\AppManager;
use Dingo\Api\Http\Request;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register() {
    }

    public function boot(Request $request, AppRepository $repository) {
        $appId = $request->header('ProjectId', null);
        $appId = $appId ? $appId : $request->input('ProjectId', null);
        $appId = $appId ? $appId : (app()->has('session') ? app()->make('session')->get('project_id') : null);
        $appId = $appId === 'undefined' ? null : $appId;
        $currentApp = $appId ? $repository->find($appId) : null;
        $appManager = app(AppManager::class);
        if($currentApp)
            $appManager->setCurrentApp($currentApp);
    }
}