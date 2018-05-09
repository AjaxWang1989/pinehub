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
use Dingo\Api\Http\Response;
use Payment\ChargeContext;
use Payment\Common\PayException;

class PaymentController extends Controller
{
    protected $orderModel = null;

    const WEB_PAY = 'web';
    const WAP_PAY = 'wap';
    const APP_PAY = 'app';
    const BAR_PAY = 'bar';
    const QR_PAY  = 'qr';
    const PUB_PAY = 'public';
    const MINI_PAY = 'miniProgram';


    public function __construct(OrderRepositoryEloquent $orderRepositoryEloquent)
    {
        $this->orderModel = $orderRepositoryEloquent;
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

    public function notify(string $type)
    {
        $notify = app('payment.'.$type.'.notify');
        $notify->notify(function (){
            $this->notifyCallback();
        });
    }

    protected function notifyCallback ()
    {

    }
}