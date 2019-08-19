<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-15
 * Time: 下午7:43
 */

namespace App\Entities\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait JsonQuery
{
    public function scopeJsonSearch(Builder $query, $key, $value)
    {
        if ($value === null) {
            $value = [$value];
        } else {
            $value = (array)$value;
        }
        $keys = explode('->', $key);
        $searchKey = '';
        $column = null;
        if (count($keys) > 1) {
            $column = "`" . array_shift($keys) . "`";
            $searchKey .= '$."' . array_shift($keys) . '"';
            foreach ($keys as $k) {
                $searchKey .= '."' . $k . '"';
            }
        } else {
            $column = "`$key`";
        }
        foreach ($value as $index => $item) {
            if ($item === null) {
                $query->whereRaw(DB::raw("JSON_TYPE(JSON_EXTRACT($column, '$searchKey')) = 'NULL'"));
            } else {
                $key = $searchKey ? "$column->'$searchKey'" : $column;
                if ($index > 0)
                    $query->orWhereNotNull(DB::raw("JSON_SEARCH($key, 'one', '$item')"));
                else
                    $query->whereNotNull(DB::raw("JSON_SEARCH($key, 'one', '$item')"));
            }

        }
        return $query;
    }
}