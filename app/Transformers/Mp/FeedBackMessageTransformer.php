<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/22
 * Time: 18:39
 */

namespace App\Transformers\Mp;

use League\Fractal\TransformerAbstract;
use App\Entities\FeedBackMessage;


class FeedBackMessageTransformer extends TransformerAbstract
{
    public function transform(FeedBackMessage $model){
        return [
            'comment' => $model->comment,
            'mobile' => $model->mobile,
        ];
    }
}