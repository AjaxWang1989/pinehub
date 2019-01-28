<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\Merchant;

use App\Entities\App;
use App\Entities\Card;
use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
use App\Entities\MpUser;
use App\Entities\ShopManager;
use App\Exceptions\HttpValidationException;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\Merchant\SmsLoginRequest;
use App\Repositories\MpUserRepository;
use App\Repositories\AppRepository;
use App\Repositories\ShopManagerRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use App\Repositories\CustomerTicketCardRepository;
use App\Services\AppManager;
use App\Transformers\Merchant\ShopManagerTransformer;
use App\Transformers\Mp\MpUserTransformer;
use App\Transformers\Mp\MpUserInfoMobileTransformer;
use App\Transformers\Mp\AppAccessTransformer;
use App\Transformers\Mp\MvpLoginTransformer;
use Carbon\Carbon;
use Curder\LaravelAliyunSms\AliyunSms;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Response\JsonResponse;
use App\Exceptions\UserCodeException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;


class AuthController extends Controller
{
    /**
     * @param string $mobile
     *
     *
     * @return AuthController|\Dingo\Api\Http\Response\Factory|\Illuminate\Foundation\Application|\Laravel\Lumen\Application|mixed
     * @throws \Exception
     */
    public function verifyCode(string  $mobile)
    {
        if(!isMobile($mobile)) {
            throw new ValidationHttpException(['手机格式错误'], null, [],HTTP_REQUEST_VALIDATE_ERROR);
        }
        mt_srand((int)(microtime(true) * 1000));
        $code = mt_rand(100000, 1000000);
        cache()->put($this->getSmsCodeKey($mobile), $code, 5);
        $tmpId = 'SMS_157075027';
        $params = [
            'code' => $code
        ];
        $result = app(AliyunSms::class)->send(strval($mobile), $tmpId, $params);
        if($result) {
            return $this->response(new JsonResponse(['message' => 'send SMS is OK', 'code' => $code]));
        }else{
            throw new HttpException(HTTP_STATUS_INTERNAL_SERVER_ERROR, '短信发送失败');
        }
    }

    /**
     * 判断是否为当前的小程序
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */

    public function appAccess(Request $request)
    {
        $request = $request->all();
        $item = app(AppRepository::class)
            ->findWhere(['id'=>$request['app_id']])
            ->first();

        $sign = md5(md5($item['id'].$item['secret']).$request['timestamp']);

        if ($request['sign'] == $sign){
            $accessToken = Hash::make($item['id'], with($item, function (App $app) {
                return $app->toArray();
            }));

            app(AppManager::class)->setCurrentApp($item)
                ->setAccessToken($accessToken);

            $item['access_token'] = $accessToken;
            $item['ttl'] = Carbon::now()->addMinute(app(AppManager::class)->ttl)->format('Y-m-d H:i:s');

            return $this->response()
                ->item($item, new AppAccessTransformer());
        }else{
            $errCode = 'sign签名错误';
            throw new UserCodeException($errCode);
        }
    }

    protected function getSmsCodeKey($mobile)
    {
        return "auth.mobile.{$mobile}";
    }


    /**
     * @param SmsLoginRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function login(SmsLoginRequest $request) {
        try{
            $code = cache($this->getSmsCodeKey(($mobile = $request->input('mobile'))));
            if(!$code || $code !== $request->input('code')) {
                throw new \Exception();
            }
        }catch (\Exception $exception) {
            Log::error('code error');
            throw new ValidationHttpException(['验证码不存在或者不匹配'], null, [], AUTH_LOGOUT_FAIL);
        }

        $manager = $this->shopManagerRepository->whereMobile($mobile);

        if(!$manager) {
            throw new ValidationHttpException(['没有此用户'], null, [], AUTH_LOGOUT_FAIL);
        }

        if(!$manager->shop) {
            throw new ValidationHttpException(['不是店主无法登陆'], null, [], AUTH_LOGOUT_FAIL);
        }
        Log::info('shop info', $manager->shop->toArray());
        $shop = app(ShopRepository::class)->todayOrderInfo($manager->shop->id);

        $token = Auth::login($manager);
        $tokenMeta = [
            'value' => $token,
            'ttl' => Carbon::now(config('app.timezone'))->addMinute(config('jwt.ttl')),
            'refresh_ttl' => Carbon::now(config('app.timezone'))->addMinute(config('jwt.refresh_ttl'))
        ];
        cache([$token => $tokenMeta['ttl']->getTimestamp()], $tokenMeta['ttl']);
        return $this->response->item($manager, new ShopManagerTransformer($shop->toArray()))
            ->addMeta('token', $tokenMeta);
    }

    public function shop()
    {
        app(ShopRepository::class)->todayOrderInfo(1);
    }
}
