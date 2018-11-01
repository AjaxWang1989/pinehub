<?php

namespace App\Criteria\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchRequestCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class SearchRequestCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder           $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fieldsSearchable = $repository->getFieldsSearchable();
        $searchStr = Request::query('searchJson', null);
        if(!$searchStr) {
            return $model;
        }
        $searchJson = is_array($searchStr) ? $searchStr : json_decode(base64_decode($searchStr), true);
        $fields = [];
        foreach ($searchJson as $key => $value) {
            if(isset($fieldsSearchable[$key]) || array_search($key, $fieldsSearchable)) {
                $fields[$key] = $value;
            }
        }
        Log::info('search fields', [$fields, $searchJson]);
        $model = $this->parseSearch($fields, $model);
        return $model;
    }

    /**
     * parse search query
     * @param array $fields
     * @param Builder|Model $model
     * @return Model|Builder
     * */
    protected function parseSearch(array $fields, $model)
    {
        return $model->where(function (Builder $query) use($fields) {
            foreach ($fields as $key => $value) {
                $relation = null;
                if(stripos($key, '.')) {
                    $explode = explode('.', $key);
                    $key = array_pop($explode);
                    $relation = implode('.', $explode);
                }
                $modelTableName = $query->getModel()->getTable();
                if(is_null($relation)) {
                    $key = $modelTableName.'.'.$key;
                    $query = $this->buildQuery($key, $value, $query);
                }else{
                    $query = $this->buildQuery($key, $value, $query, $relation);
                }
            }
            return $query;
        });

    }

    protected function buildQuery($key, $value, Builder $query, $relation = null)
    {
        if(!is_array($value)) {
            if(!$relation) {
                return $query->where($key, $value);
            }else{
                return $query->whereHas($relation, function (Builder $query)use($key, $value){
                    return $query->where($key, $value);
                });
            }
        }else{
            $count = count($value);
            if($count > 1 && isset($value[$count - 1])) {
                $items = $value;
                if(!$relation) {
                    return $query->where(function (Builder $query) use($items, $key) {
                        foreach ($items as $item ) {
                            if(!is_array($item)) {
                                $query = $query->where($key, $item);
                            }else{
                                if($item['join']) {
                                    $query = $this->addConditionInQuery($item, $query, $key);
                                }else{
                                    $query = $query->orWhere(function (Builder $query) use ($key, $item){
                                        return $this->addConditionInQuery($item, $query, $key);
                                    });
                                }

                            }
                        }
                        return $query;
                    });
                }else{
                    return $query->whereHas($relation, function (Builder $query) use($items, $key){
                        $in = false;
                        foreach ($items as $item ) {
                            if(!is_array($item)) {
                               $in = true;
                            }else{
                                if($item['join']) {
                                    $query = $this->addConditionInQuery($item, $query, $key);
                                }else{
                                    $query = $query->orWhere(function (Builder $query) use ($key, $item){
                                        return $this->addConditionInQuery($item, $query, $key);
                                    });
                                }

                            }
                        }
                        if($in) {
                            $query = $query->whereIn($key, $items);
                        }
                        return $query;
                    });
                }


            }else{
                $item = $value;
                if(isset($item['join'])) {
                    if(!$relation) {
                        return $this->addConditionInQuery($item, $query, $key);
                    }else{
                        return $query->whereHas($relation, function (Builder $query) use($item, $key) {
                            return $this->addConditionInQuery($item, $query, $key);
                        });
                    }

                }else{
                    if(!$relation) {
                        return $query->orWhere(function (Builder $query) use ($key, $item){
                            return $this->addConditionInQuery($item, $query, $key);
                        });
                    }else{
                        return $query->orWhereHas($relation, function (Builder $query) use($item, $key) {
                            return $this->addConditionInQuery($item, $query, $key);
                        });
                    }

                }
            }
        }
    }


    protected function addConditionInQuery(array  $item, Builder &$query, string $key) {
        if(!isset($item['opt'])){
            $item['opt'] = '=';
        }
        $operator = isset($item['opt']) ? $item['opt'] : '=';
        $value = $item['value'];
        switch ($operator) {
            case '=': {
                if(is_array($item['value'])) {
                    $query->whereIn($key, $value);
                }elseif ($item['value'] === null){
                    $query->whereNull($key);
                }else{
                    $query->where($key, $value);
                }
                break;
            }
            case '!=': {
                if($item['value'] === null) {
                    $query->whereNotNull($key);
                }elseif (is_array($item['value'])) {
                    $query->whereNotIn($key, $value);
                }
                break;
            }
            case '>':
            case '>=':
            case '<':
            case '<=': {
                $query->where($key, $operator, $value);
                break;
            }
            case 'like':
            case 'ilike':   {
                $query->where($key, $operator, "%{$value}%");
                break;
            }
        }
        return $query;
    }
}
