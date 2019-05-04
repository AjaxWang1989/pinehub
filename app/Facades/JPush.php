<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/2/2
 * Time: 1:05 PM
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;
use JPush\DevicePayload;
use JPush\PushPayload;
use JPush\ReportPayload;
use JPush\SchedulePayload;

/**
 * @method static PushPayload push()
 * @method static ReportPayload report()
 * @method static DevicePayload device()
 * @method static SchedulePayload schedule()
 * @method static string getAuthStr()
 * @method static int getRetryTimes()
 * @method static string getLogFile()
 * @method static boolean is_group()
 * @method static string makeUrl($url)
 * */
class JPush extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jPush';
    }
}