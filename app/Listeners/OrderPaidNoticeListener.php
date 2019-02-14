<?php

namespace App\Listeners;

use App\Events\OrderPaidNoticeEvent;
use App\Facades\JPush;
use App\Jobs\RemoveOrderPaidVoice;
use Carbon\Carbon;
use Echobool\Getui\Facades\Getui;
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
     * @param  OrderPaidNoticeEvent  $event
     * @return void
     * @throws
     */
    public function handle(OrderPaidNoticeEvent $event)
    {
        $messages = $event->broadcastWith();
        Log::info('++++++++++++ messages ++++++++++++', $messages);
        $voices = [];
        foreach ($messages as $message) {
            $result = BaiduSpeech::combine($message);
            Log::info('========= 语音 ==========', [$result, $event->broadcastOn()]);
            if($result['success']) {
                Log::info("========= result success ==========");
                $file = Storage::url($result['data']);
                array_push($voices, $file);
                dispatch((new RemoveOrderPaidVoice($file))->delay(5));
                if(($registerIds = $event->broadcastOn())) {
                    Log::info("========= result success ==========", [$registerIds]);
                    $messageId = str_random();
                    $content = [
                        'voice' => $file,
                        'message_id' => $messageId,
                        'type' => 'PAYMENT_NOTICE'
                    ];
                    if(isset($registerIds['jpush'])) {
                        JPush::push()->setPlatform(['android', 'ios'])
                            ->addRegistrationId($registerIds['jpush'])
                            ->setMessage($message, '平台收款', 'text',  $content)
                            ->send();
                    }

                    if(isset($registerIds['igt'])) {
                        try{
                            Log::info('=========+ 推送 +==========');
                            $result = Getui::pushMessageToSingle($registerIds['igt'], [
                                'content'=> json_encode($content),
                                'payload' => json_encode($content),
                                'body' => $message,
                                'title'=>'平台收款'
                            ]);
                            Log::info('========= 推送 ==========', [$result]);
                        }catch (\Exception $exception) {
                            Log::info('---------- error -----------'. $exception->getMessage(), $exception->getTrace());
                        }
                    }

                }
            }
        }

//        Log::info('----- order paid notice voice -------', $voices);
//        $cacheVoices = cache($event->broadcastOn(), []);
//        cache([$event->broadcastOn() => array_merge($cacheVoices, $voices)], Carbon::now()->addMinute(10));
    }
}
