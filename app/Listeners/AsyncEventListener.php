<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/2
 * Time: 上午9:29
 */

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AsyncEventListener implements ShouldQueue
{
    use InteractsWithQueue;


    public $queue = "async.event.listener";
}