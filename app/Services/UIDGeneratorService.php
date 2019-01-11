<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/25
 * Time: 上午10:58
 */

namespace App\Services;


use Carbon\Carbon;
use Illuminate\Cache\RedisLock;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    protected $segmentKey = null;

    protected $dateTimeFormat = 'YmdHis';

    const UID_LOCK_TIME = 3;//unit second

    const WAIT_MAX_TIME = 6;

    const INTERVAL_TIME = 1;

    protected $wait_time = -1;

    /**
     * @var RedisLock
     * */
    protected $lock = null;

    /**
     * UIDGeneratorService constructor.
     */
    public function __construct()
    {
        $this->now = Carbon::now();
        $this->next = $this->now->addSeconds($this->nextTimeSeconds);
        $this->segmentInit();
    }

    /**
     * @return string
     * @throws \Exception
     */
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
        $this->wait_time ++;
        return $this->uidGenerator();
    }

    /**
     *
     * @param string $format
     * @param int $segmentLength
     * @return string
     * @throws \Exception
     */
    public function getUid(string $format, int $segmentLength)
    {
        return $this->handle($format, $segmentLength);
    }

    /**
     *
     * @param string $mainUid
     * @param int $subUidSegmentLength
     * @return string
     * @throws \Exception
     */
    public function getSubUid(string $mainUid, int $subUidSegmentLength)
    {
        $this->segmentKey = $mainUid;
        $this->segmentMaxLength = $subUidSegmentLength;
        $this->segmentInit();
        return $this->uidGenerator();
    }

    /**
     *
     * @return string
     * @throws \Exception
     */
    protected function uidGenerator()
    {
        $orderId = null;
        $key = $this->segmentRandKey();
        $left = $key;
        $right = $key;
        while ($this->segment[$left] && $this->segment[$right]) {
            $left --;
            $right ++;
        }
        $key = $this->segment[$left] ? ($this->segment[$right] ? null : $right) : $left;
        if($key === null) {
            throw new \Exception('无法生产需要的UID');
        }
        if(!$this->lock){
            $this->lock = Cache::lock(self::UID_LOCK.'.'.$this->segmentKey.'.'.$key, self::UID_LOCK_TIME);
        }
        if ($this->lock) {
            $this->segment->put($key, true);
            Cache::put($this->segmentKey, $this->segment->toArray(), 1);
            $this->lock->release();
            $this->lock = null;
            $keyLength = strlen($this->segmentMaxLength.'') - 1;
            $key = sprintf("%0{$keyLength}d", $key);
            return generatorUID($this->segmentKey, $key);
        }elseif($this->wait_time < self::WAIT_MAX_TIME){
            sleep(self::INTERVAL_TIME);
            return $this->handle();
        }else{
            return null;
        }
    }

    /**
     *
     * @return int
     * @throws \Exception
     */
    protected function segmentRandKey()
    {
        return random_int($this->segmentMaxLength / 4, $this->segmentMaxLength * 3 / 4);
    }

    /**
     *
     * @return Collection
     */
    protected function newSegment()
    {
        $segment = array();
        for($i = 0; $i < $this->segmentMaxLength; $i ++) {
            $segment[$i] = false;
        }
        Cache::put($this->segmentKey, $segment, 1);
        return collect($segment);
    }

    protected function segmentInit()
    {
        if(!$this->segmentKey){
            $this->segmentKey = $this->now->format($this->dateTimeFormat);
            $this->segment = $this->getSegment();

            $emptySegment = $this->segment->filter(function ($value){
                return !$value;
            });

            if ($this->segment && $emptySegment->count() === 0) {
                $this->segmentKey = $this->next->format($this->dateTimeFormat);
                $this->segment = $this->nextSegment();
            }
        }else{
            $this->segment = $this->getSegment();
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