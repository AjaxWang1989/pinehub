<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 1:16
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\MpUser;

class MpUserInfoTransformer extends TransformerAbstract
{
    public function transform(MpUser $model)
    {
        return [
            'id' =>$model->id,
            'nickname' => $model->nickname,
            'type' => $model->type,
            'open_id' => $model->openId,
            'avatar' => $model->avatar,
            'country' => $model->country,
            'province' => $model->province,
            'city' => $model->city,
            'sex' => $model->sex,
            'ticket_num' => $model->ticketNum,
        ];
    }
}