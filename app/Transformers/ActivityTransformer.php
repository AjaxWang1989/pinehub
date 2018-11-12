<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 18:57
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Activity;


class ActivityTransformer extends TransformerAbstract
{
    public function transform(Activity $model)
    {
        return [
            'id'  => $model->id,
            'title' => $model->title,
            'poster_img' => $model->posterImg,
            'start_at' => $model->startAt ? $model->startAt->format('Y-m-d H:i:s') : null,
            'end_at' => $model->endAt ? $model->endAt->format('Y-m-d H:i:s') : null,
            'description' => $model->description,
        ];
    }
}