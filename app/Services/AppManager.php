<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/27
 * Time: 下午8:54
 */

namespace App\Services;


use App\Entities\App;
use App\Entities\MiniProgram;
use App\Entities\OfficialAccount;
use App\Entities\WechatConfig;
use App\Repositories\AppRepository;
use App\Services\AliPay\AliPayOpenPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Application;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;

/**
 * @property App $currentApp
 * @property OfficialAccount $officialAccount
 * @property MiniProgram $miniProgram
 * @property OpenPlatform $openPlatform
 * @property AliPayOpenPlatform $aliPayOpenPlatform
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

    protected $aliPayOpenPlatform = null;

    /**
     * @var WechatConfig|null
     * */
    protected $miniProgram = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $repository = $app->make(AppRepository::class);
        $this->openPlatform = $this->app->make('wechat')->openPlatform();
        $appId = $this->getAppId();
        if($appId) {
            $this->currentApp = $repository->find($appId);
            $this->officialAccount = with($this->currentApp, function (App $app){
                return $app->officialAccount;
            });

            $this->miniProgram = with($this->currentApp, function (App $app){
                return $app->miniProgram;
            });
        }
        $this->aliPayOpenPlatform = new AliPayOpenPlatform(config('ali.payment'));
    }

    public function setCurrentApp($currentApp)
    {
        $this->currentApp = $currentApp;
    }

    public function getAppId()
    {
        $request = Request::capture();
        $appId = $request->header('selected_appid', null);
        $appId = $appId ? $appId : $request->query('selected_appid', null);
        $appId = $appId ? $appId : (app()->has('session') ? app('session')->get('selected_appid') : null);
        return $appId;
    }

    public function officialAccount()
    {
        if(!$this->officialAccount) {
            $repository = $this->app->make(AppRepository::class);
            Log::debug('current app 1 ', [$this->currentApp]);
            $appId = $this->currentApp ? $this->currentApp->id : $this->getAppId();
            if($appId) {
                $this->currentApp = $repository->find($appId);
                $this->officialAccount = with($this->currentApp, function (App $app){
                    return $app->officialAccount;
                });
            }
        }

        return $this->officialAccount;
    }

    public function miniProgram()
    {
        if(!$this->miniProgram){
            $repository = $this->app->make(AppRepository::class);
            $appId = $this->currentApp ? $this->currentApp->id : $this->getAppId();
            if($appId) {
                $this->currentApp = $repository->find($appId);
                $this->miniProgram = with($this->currentApp, function (App $app){
                    return $app->miniProgram;
                });
            }
        }
        return $this->miniProgram;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->{$name};
    }
}