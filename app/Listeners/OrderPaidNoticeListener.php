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
                    JPush::push()->setPlatform(['android', 'ios'])
                        ->addRegistrationId($registerIds['jpush'])
                        ->setMessage($message, '', 'text', ['voice_url' => $file])
                        ->send();

                    Getui::pushMessageToSingle($registerIds['igt'], [
                        'content'=> json_encode(['voice_url' => $file]),
                        'text' => $message,
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
