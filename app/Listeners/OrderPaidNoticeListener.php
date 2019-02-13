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
        $voices = [];
        foreach ($messages as $message) {
            $result = BaiduSpeech::combine($message);
            if($result['success']) {
                $file = Storage::url($result['data']);
                array_push($voices, $file);
                dispatch((new RemoveOrderPaidVoice($file))->delay(5));
                if(($registerIds = $event->broadcastOn())) {
                    $messageId = str_random();
                    $content = [
                        'voice' => $file,
                        'message_id' => $messageId,
                        'type' => 'PAYMENT_NOTICE'
                    ];
                    JPush::push()->setPlatform(['android', 'ios'])
                        ->addRegistrationId($registerIds['jpush'])
                        ->setMessage($message, '平台收款', 'text',  $content)
                        ->send();

                    Getui::pushMessageToSingle($registerIds['igt'], [
                        'content'=> json_encode($content),
                        'payload' => json_encode($content),
                        'body' => $message,
                        'title'=>'平台收款'
                    ]);
                }
            }
        }

//        Log::info('----- order paid notice voice -------', $voices);
//        $cacheVoices = cache($event->broadcastOn(), []);
//        cache([$event->broadcastOn() => array_merge($cacheVoices, $voices)], Carbon::now()->addMinute(10));
    }
}
