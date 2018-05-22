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
use App\Transformers\Api\UpdateResponseTransformer;
use Dingo\Api\Http\Request as DingoRequest;
use Illuminate\Support\Facades\Log;
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
            $signed = $charge->charge($order);
            Log::debug('signed', [$signed]);
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
        if (preg_match(WECHAT_PAY_USER_AGENT, $userAgent)) {
            return app('wechat.official_account.default')
                ->oauth->scopes(['snsapi_base'])
                ->setRequest($request)
                ->redirect(webUriGenerator('/wechat/aggregate.html?shop_id='.$request->input('shop_id', null)));
        } elseif (preg_match(ALI_PAY_USER_AGENT, $userAgent)) {
            return redirect(app('ali.user.oauth')->charge(['scopes' => 'auth_base', 'state' => 'init']));
            //return redirect(webUriGenerator('/ali/aggregate.html?shop_id='.$request->input('shop_id', null)));
            //$appId = config('app.payment.app_id');
            //$redirect = urlencode(config('app.payment.redirect_url'));
            //return redirect("https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appId}&scope=auth_base&redirect_uri={$redirect}&state=init");
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
}