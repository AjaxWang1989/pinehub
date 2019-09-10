<?php

namespace App\Listeners;

use App\Entities\Order;
use App\Events\OrderPaidNoticeEvent;
use App\Events\Socket\PaidNoticeEvent;
use App\Facades\JPush;
use App\Jobs\RemoveOrderPaidVoice;
use Carbon\Carbon;
use Echobool\Getui\Facades\Getui;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Jormin\BaiduSpeech\BaiduSpeech;
use Illuminate\Support\Facades\Storage;

class OrderPaidNoticeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaidNoticeEvent $event
     * @return void
     * @throws
     */
    public function handle(OrderPaidNoticeEvent $event)
    {
        $messages = $event->broadcastWith();
        Log::info('++++++++++++ messages ++++++++++++', [$messages, $event->noticeVoiceCacheKey(), $event->orderId]);
        $voices = [];
        foreach ($messages as $message) {
            $result = BaiduSpeech::combine($message);
            Log::info('========= 语音 ==========', [$result, $event->broadcastOn(), $event->noticeVoiceCacheKey(), $event->orderId]);
            if ($result['success']) {
                Log::info("========= result success ==========");
                $file = Storage::url($result['data']);
                array_push($voices, $file);
                dispatch((new RemoveOrderPaidVoice($result['data']))->delay(60));
                $messageId = md5(microtime(true));
                $content = [
                    'voice' => $file,
                    'message_id' => $messageId,
                    'type' => 'PAYMENT_NOTICE',
                    'order_id' => $event->orderId
                ];
                $voiceCacheKey = $event->noticeVoiceCacheKey($messageId);
                Log::info('------------ notice voice cache key ------', [$voiceCacheKey]);
                /*轮训数组*/
                Cache::add($voiceCacheKey, $content, 1);

                /*广播推送*/
                broadcast(new PaidNoticeEvent(Order::find($event->orderId), $file));

                /*手机内部推送APNS*/
                if (($registerIds = $event->broadcastOn())) {
                    if (isset($registerIds['jpush'])) {
                        JPush::push()->setPlatform(['android', 'ios'])
                            ->addRegistrationId($registerIds['jpush'])
                            ->setMessage($message, '平台收款', 'text', $content)
                            ->send();
                    }
                    if (isset($registerIds['igt'])) {
                        try {
                            app('Getui')->pushMessageToSingle($registerIds['igt'], [
                                'content' => json_encode($content),
                                'payload' => json_encode($content),
                                'body' => $message,
                                'title' => '平台收款'
                            ], 4);
                        } catch (\Exception $exception) {

                        }
                    }

                }
            }
        }
    }
}
