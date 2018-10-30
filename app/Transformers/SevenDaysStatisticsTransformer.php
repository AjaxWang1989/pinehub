<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/10/30
 * Time: 下午2:56
 */

namespace App\Transformers;
use League\Fractal\TransformerAbstract;

class SevenDaysStatisticsTransformer extends TransformerAbstract
{
    /**
     * Transform the  SevenDaysStatistics entity.
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return $item;
    }
}