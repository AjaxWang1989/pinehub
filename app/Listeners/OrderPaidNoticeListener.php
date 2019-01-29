<?php

namespace App\Listeners;

use App\Events\OrderPaidNoticeEvent;
use App\Jobs\RemoveOrderPaidVoice;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Jormin\BaiduSpeech\BaiduSpeech;
use Toplan\Sms\Storage;

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
            }
        }
        Log::info('----- order paid notice voice -------', [$voices]);
        $cacheVoices = cache($event->broadcastOn(), []);
        cache([$event->broadcastOn() => array_merge($cacheVoices, $voices)], Carbon::now()->addMinute(10));
    }
}
