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
//    private $except = ['/^\/app\/logo\/(.*)$/'];
    private $except = [
        '/app/logo/default',
        '/app/logo/cloud',
    ];

    public function register()
    {
    }

    public function boot(Request $request, AppRepository $repository)
    {
        $path = $request->getPathInfo();
        if (in_array($path, $this->except)) {
            return;
        }
        $this->setCurrentApp($request, $repository);
    }

    private function setCurrentApp(Request $request, AppRepository $repository)
    {
        $appId = $request->header('ProjectId', null);
        $appId = $appId ? $appId : $request->input('ProjectId', null);
        $appId = $appId ? $appId : (app()->has('session') ? app()->make('session')->get('project_id') : null);
        if($appId){
            $currentApp = $appId ? $repository->find($appId) : null;
            $appManager = app(AppManager::class);
            if ($currentApp)
                $appManager->setCurrentApp($currentApp);
        }
    }
}