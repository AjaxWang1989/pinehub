<?php

namespace App\Listeners;

use App\Events\OrderPaidNoticeEvent;
use App\Facades\JPush;
use App\Jobs\RemoveOrderPaidVoice;
use Carbon\Carbon;
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
                if(($registerId = $event->broadcastOn())) {
                    JPush::push()->setPlatform(['android', 'ios'])
                        ->addRegistrationId($registerId)
                        ->setMessage($message, '', 'text', ['voice_url' => $file])
                        ->send();
                }
            }
        }
    }
}
