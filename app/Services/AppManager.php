<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/27
 * Time: 下午8:54
 */

namespace App\Services;


use App\Entities\App;
use App\Entities\WechatConfig;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Application;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;

/**
 * @property App $currentApp
 * @property WechatConfig $officialAccount
 * @property WechatConfig $miniProgram
 * @property OpenPlatform $openPlatform
 * */
class AppManager
{
    /**
     * @var App|null
     * */
    protected $currentApp = null;

    /**
     * @var Application|null
     * */
    protected $app = null;

    /**
     * @var WechatConfig|null
     * */
    protected $officialAccount = null;

    /**
     * @var OpenPlatform|null
     * */
    protected $openPlatform = null;

    /**
     * @var WechatConfig|null
     * */
    protected $miniProgram = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $repository = $app->make(AppRepository::class);
        $this->openPlatform = $this->app->make('wechat')->openPlatform();
        $request = $app->make('request');
        $appId = $request->header('selected_appid', null);
        $appId = $appId ? $appId : $request->query('selected_appid', null);
        if($appId) {
            $this->currentApp = $repository->find($appId);
            $this->officialAccount = with($this->currentApp, function (App $app){
                return $app->officialAccount;
            });

            $this->miniProgram = with($this->currentApp, function (App $app){
                return $app->miniProgram;
            });
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->{$name};
    }
}