<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 12:11
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\Category;


class CategoriesTransformer extends TransformerAbstract
{
    public function transform(Category $model){
        return [
            'id'=>$model->id,
            'name'=>$model->name,
        ];
    }
}