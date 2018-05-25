<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/25
 * Time: 上午10:58
 */

namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UIDGeneratorService implements InterfaceServiceHandler
{
    /**
     * @var Collection
     * */
    protected $segment = null;

    /**
     * @var Carbon
     * */
    protected $now = null;

    /**
     * @var Carbon
     * */
    protected $next = null;

    protected $nextTimeSeconds = 1;//unit second

    protected $segmentMaxLength = SEGMENT_MAX_LENGTH;

    const UID_LOCK = 'uid.lock';

    protected $segmentKey = '';

    protected $dateTimeFormat = 'YmdHis';

    const UID_LOCK_TIME = 3;//unit second

    /**
     * UIDGeneratorService constructor.
     */
    public function __construct()
    {
        $this->now = Carbon::now();
        $this->next = $this->now->addSeconds($this->nextTimeSeconds);
        $this->segmentInit();
    }

    public function handle()
    {
        // TODO: Implement handle() method.
        $argNum = func_num_args();
        if ($argNum === 3) {
            list($this->dateTimeFormat, $this->segmentMaxLength, $this->nextTimeSeconds) = func_get_args();
        } else if ($argNum === 2) {
            list($this->dateTimeFormat, $this->segmentMaxLength) = func_get_args();
        }

        if($this->now->timestamp < Carbon::now()->timestamp){
            $this->now = Carbon::now();
            $this->next = $this->now->addSeconds($this->nextTimeSeconds);
            $this->segmentInit();
        }else if($this->nextTimeSeconds) {
            $this->next = $this->now->addSeconds($this->nextTimeSeconds);
        }

        return $this->uidGenerator();
    }

    public function getUid(string $format, int $segmentLength)
    {
        return $this->handle($format, $segmentLength);
    }

    protected function uidGenerator()
    {
        $orderId = null;
        $key = $this->segmentRandKey();
        $left = $key;
        $right = $key;
        $lock = Cache::lock(self::UID_LOCK, self::UID_LOCK_TIME);
        while ($this->segment[$left] && $this->segment[$right]) {
            $left --;
            $right ++;
        }
        $key = $this->segment[$left] ? ($this->segment[$right] ? null : $right) : $left;
        if($key === null) {
            throw new \Exception('无法生产需要的UID');
        }
        $this->segment->put($key, true);
        Cache::put($this->segmentKey, $this->segment->toArray());
        $lock->release();
        $keyLength = strlen($this->segmentMaxLength.'') - 1;
        $key = sprintf("%0{$keyLength}d", $key);
        return generatorUID($this->dateTimeFormat, $key);
    }

    protected function segmentRandKey()
    {
        return random_int(0, $this->segmentMaxLength);
    }

    protected function newSegment()
    {
        $segment = array();
        for($i = 0; $i < $this->segmentMaxLength; $i ++) {
            $segment[$i] = false;
        }
        Cache::put($this->segmentKey, $segment);
        return collect($segment);
    }

    protected function segmentInit()
    {
        $this->segmentKey = $this->now->format($this->dateTimeFormat);
        $this->segment = $this->getSegment();

        $emptySegment = $this->segment->filter(function ($value){
                return !$value;
        });

        if ($this->segment && $emptySegment->count() === 0) {
            $this->segmentKey = $this->next->format($this->dateTimeFormat);
            $this->segment = $this->nextSegment();
        }
    }

    public function getSegment()
    {
        $segment = Cache::get($this->segmentKey);
        if($segment){
            return collect((array)$segment);
        }else{
           return $this->newSegment();
        }

    }

    protected function nextSegment()
    {
        return $this->newSegment();
    }
}