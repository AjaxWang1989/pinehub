<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/23
 * Time: 上午10:17
 */

namespace App\Http\Controllers\Payment;


use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryEloquent;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
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

    public function __construct(OrderRepositoryEloquent $orderRepositoryEloquent, Application $app)
    {
        $this->orderModel = $orderRepositoryEloquent;
        $this->app = $app;
    }

    /**
     * 统一下单
     * @param int $id
     * @param string $type
     * @param ChargeContext|null $charge
     * @return Response| null
     * @throws
     * */
    public function preOrder(string $type, int $id, $charge = null)
    {
        $order = $this->orderModel->find($id);
        try{
            $signedStr = $charge->charge($order);
            return $this->response([
                'signed' => $signedStr
            ]);
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

    public function aggregate (Request $request)
    {
        $userAgent = $request->userAgent();
        $version = $request->version();
        if (preg_match(WECHAT_PAY_USER_AGENT, $userAgent)){
            return $this->app->make('api.dispatcher')->version($version)->post('/wechat/payment',
                $request->toArray());
        } elseif (preg_match(ALI_PAY_USER_AGENT, $userAgent)) {
            return $this->app->make('api.dispatcher')->version($version)->post('/ali/payment',
                $request->toArray());
        } else {
            $this->response()->error('未知支付方式', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return null;
    }
}