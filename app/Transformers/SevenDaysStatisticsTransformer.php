<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/10/30
 * Time: 下午2:56
 */

namespace App\Transformers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class SevenDaysStatisticsTransformer extends TransformerAbstract
{
    /**
     * Transform the  SevenDaysStatistics entity.
     * @param Collection $collection
     * @return array
     */
    public function transform(Collection $collection)
    {
        $statistics = [
            'last_week' => [],
            'this_week' => []
        ];
        $collection->map(function ($item) use(&$statistics){
            if($this->isLastWeek($item['paid_at'])) {
                array_push($statistics['last_week'], $item['count']);
            }else{
                array_push($statistics['this_week'], $item['count']);
            }
        });

        return $statistics;
    }

    /**
     *
     * @param Carbon $time
     * @return bool
     */
    private function isLastWeek(Carbon $time)
    {
        $end = Carbon::now(config('app.timezone'));
        $start = $end->copy()->startOfWeek();
        if($start->timestamp > $time->timestamp) {
            return true;
        }else{
            return false;
        }
    }
}