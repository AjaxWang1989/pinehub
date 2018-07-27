<?php

namespace App\Criteria\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        $searchStr = Request::query('searchJson');
        $searchJson = json_decode(base64_decode($searchStr), true);
        foreach ($searchJson as $key => $value) {
            if(in_array($key, $fieldsSearchable)) {
                $fields[$key] = $value;
            }
        }
        return $model;
    }

    /**
     * parse search query
     * @param array $fields
     * @param Builder|Model $model
     * */
    protected function parseSearchQuery(array $fields, $model)
    {
        $model->where(function (Builder $query) use($fields) {
            foreach ($fields as $key => $value) {
                if(!is_array($value)) {
                    $query->where($key, $value);
                }else{
                    $count = count($value);
                    if($count > 1 && isset($value[$count - 1])) {
                        $items = $value;
                        foreach ($items as $item ) {
                            if(!is_array($item)) {
                                $query->where($key, $item);
                            }else{
                                if($item['join']) {
                                    if(!isset($item['opt'])){
                                        $item['opt'] = '=';
                                    }
                                    switch ($item['opt']) {
                                        case '=': {
                                            if(is_array($item['value'])) {
                                                $query->whereIn($key, $item['value']);
                                            }elseif ($value === null){
                                                $query->whereNull($key);
                                            }else{
                                                $query->where($key, $item['value']);
                                            }
                                            break;
                                        }
                                        case '!=': {
                                            if($item['value'] === null) {
                                                $query->whereNotNull($key);
                                            }elseif (is_array($item['value'])) {
                                                $query->whereNotIn($key, $item['value']);
                                            }
                                            break;
                                        }
                                        case '>':
                                        case '>=':
                                        case '<':
                                        case '<=': {
                                            $query->where($key, $item['opt'], $item['value']);
                                            break;
                                        }
                                    }

                                }else{
                                    $query->orWhere($key, $item['opt'], $item['value']);
                                }

                            }
                        }
                    }
                }
            }
        });

    }
}
