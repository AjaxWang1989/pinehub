<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/29
 * Time: 下午2:28
 */

namespace App\Services\Wechat;


use App\Entities\Customer;
use App\Entities\WechatUser;
use App\Exceptions\WechatMaterialArticleUpdateException;
use App\Exceptions\WechatMaterialDeleteException;
use App\Exceptions\WechatMaterialListException;
use App\Exceptions\WechatMaterialShowException;
use App\Exceptions\WechatMaterialStatsException;
use App\Exceptions\WechatMaterialUploadException;
use App\Exceptions\WechatMaterialUploadTypeException;
use App\Services\AppManager;
use App\Services\Wechat\Components\Authorizer;
use App\Services\Wechat\Components\ComponentAccessToken;
use App\Services\Wechat\Components\MiniProgramAuthorizerInfo;
use App\Services\Wechat\Components\OfficialAccountAuthorizerInfo;
use App\Services\Wechat\OfficialAccount\AccessToken;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use EasyWeChat\Kernel\Messages\Article;
use EasyWeChat\OfficialAccount\Server\Guard;
use EasyWeChat\OfficialAccount\Server\Handlers\EchoStrHandler;
use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\CacheBridge;

class WechatService
{
    protected $config = null;

    protected $officeAccount = null;

    protected $miniProgram = null;

    protected $payment = null;

    protected $openPlatform = null;

    public function __construct(array  $config = [])
    {
        $this->config = $config;
    }

    public function setConfig(array  $config)
    {
        $this->config = $config;
    }

    public function officeAccount()
    {

        if(!$this->officeAccount) {
            if($this->config['official_account']['app_secret']) {
                $this->officeAccount= Factory::officialAccount($this->config['official_account']);
            }else{
                $appManager = app(AppManager::class);
                $appId = $appManager->officialAccount->appId;
                $this->officeAccount = $this->openPlatform()->officialAccount($appId);
            }
        }

        $this->setWechatApplication($this->officeAccount, app());

        return ($this->officeAccount);
    }

    public function openPlatform()
    {
        \Log::debug('open platform config ', $this->config);
        if(!$this->openPlatform)
            $this->openPlatform= Factory::openPlatform($this->config['open_platform']);
        $this->setWechatApplication($this->openPlatform, app());
        return ($this->openPlatform);
    }

    public function openPlatformAuthorizer(string  $authCode)
    {
        $authorizer = $this->openPlatform()->handleAuthorize($authCode);
        return new Authorizer($authorizer['authorization_info']);
    }

    public function openPlatformComponentAccess()
    {
        $token = $this->openPlatform()->access_token->getToken();
        return new ComponentAccessToken($token);
    }

    public function getOpenPlatformAuthorizer(string $appId)
    {
        $info = $this->openPlatform()->getAuthorizer($appId);
        if(isset($info['MiniProgramInfo'])) {
            return new MiniProgramAuthorizerInfo($info);
        }else{
            return new OfficialAccountAuthorizerInfo($info);
        }
    }

    public function openPlatformComponentLoginPage(string $appId = null,string $token = null, string $type = 'all', string $bizAppid = null)
    {
        $redirect = $this->openPlatform()->config['oauth']['callback'];

        $redirect = str_replace('{appId}', $appId, $redirect);
        $redirect .= "?token={$token}";
        $url = $this->openPlatform()->getPreAuthorizationUrl($redirect);
        if($type) {
            switch ($type) {
                case 'official_account': {
                    $type = 1;
                    break;
                }
                case 'mini_program': {
                    $type = 2;
                    break;
                }
                case 'all': {
                    $type = 3;
                    break;
                }
            }
        }
        if($type) {
            $url .="&auth_type={$type}";
        }

        if($bizAppid) {
            $url .= "&biz_appid={$bizAppid}";
        }
        return $url;
    }

    public function materialStats()
    {
        $stats = $this->officeAccount()->material->stats();
        if(isset($stats['errcode'])) {
            throw new WechatMaterialStatsException($stats['errmsg'], HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $stats;
    }


    public function materialList(string $type, int $offset, int $limit)
    {
        $result = $this->officeAccount()->material->list($type, $offset, $limit);
        if(isset($result['errcode'])) {
            throw new WechatMaterialListException($result['errmsg'], HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }

    /**
     * upload article to wechat
     * @param array|Article
     * @return string
     * @throws
     * */
    public function uploadArticle($articles)
    {
        $result = $this->officeAccount()->material->uploadArticle($articles);
        if(isset($result['errcode'])) {
            throw new WechatMaterialUploadException($result['errmsg'], HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $result['media_id'];
    }

    public function uploadMedia(string $type, string $path)
    {
        $result  = $this->officeAccount()->media->upload($type, $path);
        if(isset($result['errcode'])) {
            throw new WechatMaterialUploadException($result['errmsg'], HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $result['media_id'];
    }

    public function updateArticle(string $mediaId, Article $article, int $index = 0) {
        $article['media_id'] = $mediaId;
        $result = $this->officeAccount()->material->updateArticle($mediaId, $article, $index);

        if(isset($result['errcode']) && $result['errcode'] !== 0) {
            throw new WechatMaterialArticleUpdateException($result['errmsg'], HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return true;
    }

    public function uploadMaterial(string $type, string $path, string $title = null, string  $des = null)
    {
        $result = null;
        switch ($type) {
            case WECHAT_VOICE_MESSAGE: {
                $result = $this->officeAccount()->material->uploadVoice($path);
                break;
            }
            case WECHAT_VIDEO_MESSAGE: {
                $result = $this->officeAccount()->material->uploadVideo($path, $title, $des);
                break;
            }
            case WECHAT_IMAGE_MESSAGE: {
                $result = $this->officeAccount()->material->uploadImage($path);
                break;
            }
            case WECHAT_THUMB_MESSAGE: {
                $result = $this->officeAccount()->material->uploadThumb($path);
                break;
            }
            case WECHAT_NEWS_IMAGE_MESSAGE: {
                $result = $this->officeAccount()->material->uploadArticleImage($path);
                break;
            }
        }

        if($result === null) {
            throw new WechatMaterialUploadTypeException('未知素材类型');
        }

        if(isset($result['errcode'])) {
            throw new WechatMaterialUploadException($result['errmsg'].' '.$result['errcode'], $result['errcode']);
        }
        return $result;
    }

    public function deleteMaterial(string  $mediaId)
    {
        $result = $this->officeAccount()->material->delete($mediaId);
        if($result['errcode'] !== 0) {
            throw new WechatMaterialDeleteException($result['errmsg']);
        }
        return true;
    }

    public function material(string  $mediaId, bool $isTemp = false)
    {
        if($isTemp) {
            $result = $this->officeAccount()->media->get($mediaId);
        } else {
            $result = $this->officeAccount()->material->get($mediaId);
        }
        if(is_array($result) && $result['errcode'] !== 0) {
            throw new WechatMaterialShowException($result['errmsg']);
        }
        return $result;
    }

    protected function setWechatApplication($app, $laravelApp)
    {
        if (config('wechat.defaults.use_laravel_cache')) {
            $app['cache'] = new CacheBridge($laravelApp['cache.store']);
        }
        $app['request'] = $laravelApp['request'];
    }

    public function payment()
    {
        if(!$this->payment)
            $this->payment = Factory::payment($this->config['payment']);
        return $this->payment;
    }

    public function miniProgram()
    {
        if(!$this->miniProgram){
            if($this->config['mini_program']['app_secret']) {
                $this->miniProgram = Factory::miniProgram($this->config['mini_program']);
            }else{
                $appManager = app(AppManager::class);
                $appId = $appManager->miniProgram->appId;
                $this->miniProgram = $this->openPlatform()->miniProgram($appId);
            }
        }
        $this->setWechatApplication($this->miniProgram, app());
        return $this->miniProgram;
    }

    public function memberCard(array $data)
    {
        return $this->officeAccount()->card->member_card->create(MEMBER_CARD, $data);
    }

    public function redPack()
    {
        return $this->payment()->redpack;
    }

    public function couponCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(COUPON_CARD, $data);
    }

    public function discountCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(DISCOUNT_CARD, $data);
    }

    public function grouponCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(GROUPON_CARD, $data);
    }

    public function cardCodeCheck(string $cardId, string $code)
    {
        return $this->officeAccount()->card->code->check($cardId, array($code));
    }

    public function cardCodeConsume(string $cardId, string $code)
    {
        return $this->officeAccount()->card->code->consume($cardId, $code);
    }

    public function decryptCode(string  $code)
    {
        return $this->officeAccount()->card->code->decrypt($code);
    }

    public function getCard(string $cardId)
    {
        return $this->officeAccount()->card->general_card->get($cardId);
    }

    public function miniProgramServer()
    {
        return $this->miniProgram()->server;
    }

    public function officeAccountServer()
    {
        return $this->officeAccount()->server;
    }

    public function openPlatformServer()
    {
        return $this->openPlatform()->server;
    }

    public function officeAccountServerHandle()
    {
        $this->officeAccountServer()->push(function ($message) {
            return $this->serverMessageHandle($this->officeAccountServer(), $message);
        });
        return $this->officeAccountServer()->serve();
    }

    public function miniProgramServerHandle()
    {

        $this->miniProgramServer()->push(function ($message) {
           $this->serverMessageHandle($this->miniProgramServer(), $message);
        });

        return $this->miniProgramServer()->serve();
    }

    public function openPlatformServerHandle()
    {
        $this->openPlatformServer()->push(function ($message) {
            $this->serverMessageHandle($this->openPlatformServer(), $message);
        });

        return $this->openPlatformServer()->serve();
    }

    protected function serverMessageHandle(Guard $server, $message)
    {
        switch ($message['MsgType']) {
            case WECHAT_TEXT_MESSAGE: {
                return $server->dispatch();
                break;
            }
            case WECHAT_IMAGE_MESSAGE: {
                return $server->dispatch();
                break;
            }
            case WECHAT_VOICE_MESSAGE: {
                return $server->dispatch();
                break;
            }
            case WECHAT_EVENT_MESSAGE: {
                return $server->dispatch($message['Event'], $message);
                break;
            }
            case OPEN_PLATFORM_COMPONENT_VERIFY_TICKET: {
                return $server->dispatch($message['Event'], $message);
                break;
            }
            default:
                return app(EchoStrHandler::class)->handle($message);
                break;
        }
    }

    public function officialAccountAccessToken()
    {
        $accessToken = $this->officeAccount()->access_token->getToken();
        return (new AccessToken($accessToken));
    }

    public function officialAccountUser($openId)
    {
        $user = $this->officeAccount()->user->get($openId);
        $wechatUser = new Customer();
        $wechatUser->platformAppId = $this->officeAccount()->config->get('app_id');
        $wechatUser->appId = app('currentApp') ? app('currentApp')->appId : null;
        $wechatUser->platformOpenId = $user['openid'];
        if(isset($user['unionid'])) {
            $wechatUser->unionId = $user['unionid'];
        }

        if(isset($user['nickname'])){
            $wechatUser->nickname = $user['nickname'];
        }

        if(isset($user['province'])){
            $wechatUser->province = $user['province'];
        }

        if(isset($user['city'])){
            $wechatUser->city = $user['city'];
        }

        if(isset($user['country'])){
            $wechatUser->country = $user['country'];
        }

        if(isset($user['headimgurl'])) {
            $wechatUser->avatar = $user['headimgurl'];
        }

        if(isset($user['privilege'])) {
            $wechatUser->privilege = $user['privilege'];
        }

        if(isset($user['subscribe'])) {
            $wechatUser->subscribe = $user['subscribe'];
        }

        if(isset($user['subscribeScene'])) {
            $wechatUser->subscribeScene = $user['subscribe_scene'];
        }

        if(isset($user['subscribe_time'])) {
            $wechatUser->subscribeTime = date('Y-m-d h:i:s', $user['subscribe_time']);
        }

        if(isset($user['remark'])) {
            $wechatUser->remark = $user['remark'];
        }

        if(isset($user['groupid'])) {
            $wechatUser->groupId = $user['groupid'];
        }

        if(isset($user['tagid_list'])) {
            $wechatUser->tagidList = $user['tagid_list'];
        }

        if(isset($user['qr_scene'])) {
            $wechatUser->qrScene = $user['qr_scene'];
        }

        if(isset($user['qr_scene_str'])) {
            $wechatUser->qrSceneStr = $user['qr_scene_str'];
        }

        return $wechatUser;
    }

    public function openPlatformOfficialAccountAccessToken(string   $appId)
    {
        $accessToken = $this->openPlatform()->officialAccount($appId)->access_token->getToken();
        return (new AccessToken($accessToken));
    }

}