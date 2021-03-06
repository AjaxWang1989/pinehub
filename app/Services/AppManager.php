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
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Application;

/**
 * @property App $currentApp
 * @property OfficialAccount $officialAccount
 * @property MiniProgram $miniProgram
 * @property OpenPlatform $openPlatform
 * @property AliPayOpenPlatform $aliPayOpenPlatform
 * */
class AppManager implements \Serializable
{
    /**
     * @var App|null
     * */
    protected $currentApp = null;

    /**
     * @var Application|null
     * */
    protected $app = null;

    /**N
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

    public $ttl = 60;

    public $uid = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->ttl = config('jwt.ttl');
        $this->uid = md5(microtime(true));
        $this->reset();
    }

    public function reset()
    {
        $repository = $this->app->make(AppRepository::class);
        $appId = $this->getAppId();
        if ($appId) {
            $this->currentApp = $repository->find($appId);
            $this->officialAccount = with($this->currentApp, function (App $app) {
                return $app->officialAccount;
            });

            $this->miniProgram = with($this->currentApp, function (App $app) {
                return $app->miniProgram;
            });
        }
        $this->aliPayOpenPlatform = new AliPayOpenPlatform(config('ali.payment'));
    }

    public function openPlatform()
    {
        if (!$this->openPlatform) {
            $this->openPlatform = $this->app->make('wechat')->openPlatform();
        }
        return $this->openPlatform;
    }

    public function setCurrentApp($currentApp)
    {
        $this->currentApp = $currentApp;
        $this->reset();
        return $this;
    }

    public function setAccessToken(string $accessToken)
    {
        Log::debug("----- set app {$this->currentApp->id} by access token {$accessToken} ------");
        Cache::add($accessToken, $this->currentApp->id, $this->ttl);
    }

    public function getAppId()
    {
        $appId = $this->currentApp ? $this->currentApp->id : null;
        if ($appId) {
            return $appId;
        }
        return null;
    }

    public function officialAccount()
    {
        if (!$this->officialAccount) {
            $repository = $this->app->make(AppRepository::class);
            $appId = $this->getAppId();
            if ($appId) {
                $this->currentApp = $this->currentApp ? $this->currentApp : $repository->find($appId);
                $this->officialAccount = with($this->currentApp, function (App $app) {
                    return $app->officialAccount;
                });
            }
        }
        return $this->officialAccount;
    }

    public function miniProgram()
    {
        if (!$this->miniProgram) {
            $repository = $this->app->make(AppRepository::class);
            $appId = $this->getAppId();
            if ($appId) {
                $this->currentApp = $this->currentApp ? $this->currentApp : $repository->find($appId);
                $this->miniProgram = with($this->currentApp, function (App $app) {
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

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {

        return serialize([
            'currentApp' => $this->currentApp,
//            'app' => $this->app
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $this->app = app(Application::class);
        $this->currentApp = unserialize($serialized)['currentApp'];
    }
}