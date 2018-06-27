<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/27
 * Time: 下午8:54
 */

namespace App\Services;


use App\Entities\App;
use App\Repositories\AppRepository;
use Laravel\Lumen\Application;

class AppManager
{
    protected $currentApp = null;

    protected $app = null;

    protected $officialAccount = null;

    protected $openPlatform = null;

    protected $miniProgram = null;

    public function __construct(Application $app, AppRepository $repository)
    {
        $this->app = $app;
        $request = $app->make('request');
        $appId = $request->input('app_id', null);
        if($appId) {
            $this->currentApp = $repository->find($appId);
            $this->officialAccount = with($this->currentApp, function (App $app){

            });
        }
    }
}