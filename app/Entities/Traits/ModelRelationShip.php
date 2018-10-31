<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/10/31
 * Time: 下午2:39
 */

namespace App\Entities\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ModelRelationShip
{
    public function withSum($relations)
    {
        $sumRelations = [];
        if(func_num_args() === 2) {
            $key = func_get_arg(0);
            $value = func_get_arg(1);
            list($k, $v) = $this->sumRelation($key, $value);
            $sumRelations[$k] = $v;
        }elseif (func_num_args() === 1) {
            foreach ($relations as $key => $value) {
                list($k, $v) = $this->sumRelation($key, $value);
                $sumRelations[$k] = $v;
            }
        }
        return $this->withCount($relations);
    }

    private function sumRelation($key, $value)
    {
        if(is_string($value)) {
            $value = function (Builder $query) use($value, $key){
                $query->select([DB::raw("sum(`{$value}`) as {$key}_sum")]);
            };
        }
        $keys = explode('as', $key);
        if(count($keys) !== 2) {
            $key .= " as {$key}_sum";
        }
        return [$key, $value];
    }
}