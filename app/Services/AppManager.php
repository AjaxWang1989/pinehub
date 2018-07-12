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
        $request = Request::capture();
        $appId = $request->header('selected_appid', null);
        $appId = $appId ? $appId : $request->query('selected_appid', null);
        $appId = $appId ? $appId : $request->session()->get();
        Log::debug('app selected '.$appId);
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

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->{$name};
    }
}