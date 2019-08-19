<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\Merchant;

use App\Entities\Order;
use App\Events\OrderPaidNoticeEvent;
use App\Http\Response\JsonResponse;
use App\Jobs\RemoveOrderPaidVoice;
use App\Repositories\OrderRepository;
use App\Repositories\ShopRepository;
use App\Transformers\Merchant\ShopTransformer;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Jormin\BaiduSpeech\BaiduSpeech;


class NoticeController extends Controller
{
    protected $timer = 0;
    const WAIT_SECOND = 20;
    /**
     * @param int $id
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws
     */
    public function notice(int $id, Request $request)
    {
        $shop = app(ShopRepository::class)->todayOrderInfo($id);
        $token = Auth::getToken();
        Log::info('======== run time =======', [$this->timer]);
        $manager = Auth::user();
        $tokenMeta = null;
        if (cache((string)$token) - time() < 10) {
            $token = Auth::login($manager);
            $tokenMeta = [
                'value' => $token,
                'ttl' => Carbon::now(config('app.timezone'))->addMinute(config('jwt.ttl')),
                'refresh_ttl' => Carbon::now(config('app.timezone'))->addMinute(config('jwt.refresh_ttl'))
            ];
            cache([$token => $tokenMeta['ttl']->getTimestamp()], $tokenMeta['ttl']);
        }
        $key = OrderPaidNoticeEvent::noticeVoiceKeyPrefix($id);

        $keys = app('redis')->keys("*$key*");
        Log::info('------notice key prefix -----', [$key, $keys]);
        if (count($keys) > 0)
            Log::debug('------- payment voice keys -------', ['keys' => $keys]);
        $messages = [];
        foreach ($keys as $key) {
            $messages[] = unserialize(app('redis')->get($key));
            app('redis')->del($key);
        }
        $voices = collect($messages)->map(function ($message) {
            Log::debug('++++++++ payment message +++++++++', $message);
            return $message['voice'];
        });
        $orders = collect([]);
        if ($voices->count() > 0)
            $orders = app(OrderRepository::class)->findWhereIn('id', collect($messages)->map(function ($message) {
                return $message['order_id'];
            })->toArray());
        if ($orders->count() > 0) {
            $orders = $orders->map(function (Order $order) {
                return [
                    'order_no' => $order->code,
                    'pay_type' => $order->payTypeStr(),
                    'pay_amount' => number_format($order->paymentAmount, 2),
                    'paid_at' => $order->paidAt ? $order->paidAt->format('Y-m-d H:i:s') :
                        \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s')
                ];
            });
        }
        if ($voices->count() === 0 && empty($tokenMeta) && $this->timer < self::WAIT_SECOND){
            $this->timer ++;
            sleep(1);
            return $this->notice($id, $request);
        }

        return $this->response->item($shop, new ShopTransformer($voices->count() > 0))
            ->addMeta('token', $tokenMeta)
            ->addMeta('voices', $voices)
            ->addMeta('orders', $orders);
    }

    /**
     * @param Request $request
     * @return NoticeController|\Dingo\Api\Http\Response\Factory|\Illuminate\Foundation\Application|\Laravel\Lumen\Application|mixed
     * @throws \Exception
     */
    public function registerGetTuiClientId(Request $request)
    {
        $clientId = $request->input('client_id', null);
        $shopId = $request->input('shop_id', null);
        cache(["shop-{$shopId}-registerId" => [
            'igt' => $clientId
        ]], Carbon::now(config('app.timezone'))->addMinute(config('jwt.ttl')));
        Log::info("shop-{$shopId}-registerId", cache("shop-{$shopId}-registerId", []));
        return $this->response(new JsonResponse(['message' => '推送ID注册成功',
            'register' => cache("shop-{$shopId}-registerId", null)]));
    }
}
