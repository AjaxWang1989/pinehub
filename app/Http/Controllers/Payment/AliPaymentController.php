<?php /** @noinspection ALL */

namespace App\Http\Controllers\Payment;

use App\Entities\Order;
use Dingo\Api\Http\Request as DingoRequest;
use Illuminate\Http\Request as LumenRequest;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Payment\PaymentController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Payment\NotifyContext;
use App\Entities\PaymentSigned as AliPaymentSigned;
use App\Transformers\Api\PaymentSignedTransformer as AliPaymentSignedTransformer;


class AliPaymentController extends Controller
{
    /**
     * 聚合支付
     * @param DingoRequesti|LumenRequest $request
     * @return Response|View|null
     * @throws
     * */
    public function aggregate(LumenRequest $request)
    {
        $request->merge(['pay_type' => Order::ALI_PAY, 'type' => Order::OFF_LINE_PAY]);
        $order = $this->app->make('order.builder')->handle();
        $charge = app('ali.payment.aggregate');
        $order = $this->preOrder($order->buildAliAggregatePaymentOrder(), $charge);

        return $this->response()->item( new AliPaymentSigned($order),
            new AliPaymentSignedTransformer());
    }

    public function aggregatePage(LumenRequest $request)
    {
        $paymentApi = paymentApiUriGenerator('/ali/aggregate');
        $accept = "application/vnd.pinehub.v0.0.1+json";
        $userId = $request->input('buyer_id', null);
        try{
            $shop = $this->shopModel->find($request->input('shop_id'));
            return view('payment.aggregate.alipay')->with([
                'type' => Order::ALI_PAY,
                'shop' => $shop,
                'paymentApi' => $paymentApi,
                'accept' => $accept,
                'userId' => $userId,
                'app_id' => $request->input('selected_appid', null)
            ]);
        }catch (\Exception $exception){
            return view('payment.aggregate.alipay')->with([
                'type' => Order::ALI_PAY,
                'paymentApi' => $paymentApi,
                'accept' => $accept,
                'userId' => $userId,
                'app_id' => $request->input('selected_appid', null)
            ]);
        }
    }


    public function notify(string $type = 'ali', NotifyContext $notify = null)
    {
        $notify = $this->app->make('payment.ali.notify');
        parent::notify($type, $notify); // TODO: Change the autogenerated stub
    }
}
