<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/23
 * Time: 上午10:17
 */

namespace App\Http\Controllers\Payment;


use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Http\Response\UpdateResponse;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\ShopRepositoryEloquent;
use App\Services\AppManager;
use App\Transformers\Api\UpdateResponseTransformer;
use Dingo\Api\Http\Request as DingoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request as LumenRequest;
use Dingo\Api\Http\Response;
use Illuminate\View\View;
use Laravel\Lumen\Application;
use Payment\ChargeContext;
use Payment\Client\Notify;
use Payment\Common\PayException;
use Payment\NotifyContext;

class PaymentController extends Controller
{

    const WEB_PAY = 'web';
    const WAP_PAY = 'wap';
    const APP_PAY = 'app';
    const BAR_PAY = 'bar';
    const QR_PAY  = 'qr';
    const PUB_PAY = 'public';
    const MINI_PAY = 'miniProgram';

    protected $app = null;

    protected $orderModel = null;

    protected $shopModel = null;

    public function __construct(OrderRepositoryEloquent $orderRepositoryEloquent, Application $app, ShopRepositoryEloquent $shopRepositoryEloquent)
    {
        $this->orderModel = $orderRepositoryEloquent;
        $this->shopModel = $shopRepositoryEloquent;
        $this->app = $app;
        parent::__construct();
    }

    /**
     * 统一下单
     * @param array $order
     * @param ChargeContext|null $charge
     * @return Response| null
     * @throws
     * */
    public function preOrder(array $order, $charge = null)
    {
        try{
            Log::debug('order', $order);
            $signed = $charge->charge($order);
            return $signed;
        }catch (PayException $exception){
            $this->response()->error($exception->errorMessage(), HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return null;
    }

    /**
     * @param string $type
     * @param NotifyContext $notify
     * @throws
     * */
    public function notify (string $type = '', NotifyContext $notify = null)
    {
        $notify->notify($this->app->make('payment.notify'));
    }

    /**
     *@param LumenRequest|DingoRequest $request
     *@return View|RedirectResponse|null
     * */
    public function aggregate (LumenRequest $request)
    {
        $userAgent = $request->userAgent();
        $shopId = $request->input('shop_id', null);
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        app('session')->put('selected_appid', $appId);
        $customer = session('customser', null);
        Log::debug('customer', [$customer, session()->getId()]);
        if (preg_match(WECHAT_PAY_USER_AGENT, $userAgent)) {
            $paymentUri = webUriGenerator('/wechat/aggregate.html', env('WEB_PAYMENT_PREFIX'));
            if($shopId) {
                $queryStr = "?shop_id={$shopId}";
            }

            if($appId) {
                if(isset($queryStr)) {
                    $queryStr .= "&selected_appid={$appId}";
                }else{
                    $queryStr = "?selected_appid={$appId}";
                }
            }
            $uri = urlencode(isset($queryStr) ? "{$paymentUri}?{$queryStr}" : $paymentUri);
            if($customer) {
                return redirect($uri);
            }
            $redirect = config('wechat.other_sdk_payment.redirect_url');
            $redirect = "{$redirect}?redirect_uri={$uri}";
            $redirect = "{$redirect}&selected_appid={$appId}";
            return app('wechat')->officeAccount()
                ->oauth->scopes(['snsapi_base'])
                ->with(['selected_appid' => $appId])
                ->setRequest($request)
                ->redirect($redirect);

        } elseif (preg_match(ALI_PAY_USER_AGENT, $userAgent)) {
            $paymentUri = webUriGenerator('/ali/aggregate.html', env('WEB_PAYMENT_PREFIX'));
            if($shopId) {
                $queryStr = "?shop_id={$shopId}";
            }

            if($appId) {
                if(isset($queryStr)) {
                    $queryStr .= "&selected_appid={$appId}";
                }else{
                    $queryStr = "?selected_appid={$appId}";
                }
            }
            $uri = urlencode(isset($queryStr) ? "{$paymentUri}?{$queryStr}" : $paymentUri);
            if($customer) {
                return redirect($uri);
            }
            $redirect = config('ali.payment.redirect_url');
            $redirect = "{$redirect}?redirect_uri={$uri}";

            return app('ali.user.oauth')
                ->defaultOAuth()
                ->with(['selected_appid' => $appId])
                ->setRequest($request)
                ->redirect($redirect);

        } else {
            return view('404');
        }
        return null;
    }

    public function quit(Request $request, string $orderNo) {
        $order = $this->orderModel->findByField('code', $orderNo);
        if($request->ajax()){
            $order->status = Order::CANCEL;
            $result = $order->save();
            if(!$result){
                $this->response()->error('操作失败');
            }
            return $this->response()->item(new UpdateResponse('放弃支付，关闭订单'), new UpdateResponseTransformer());
        }else{
            return view('payment.quit')->with('order', $order);
        }
    }

    public function __destruct()
    {
        $this->orderModel = null;
        $this->shopModel = null;
        $this->app = null;
        parent::__destruct(); // TODO: Change the autogenerated stub
    }
}