<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 21:09
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\MpUser;

class MpUserInfoMobileTransformer extends TransformerAbstract
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
            'mobile' => $model->member->mobile,
            'vip_level' => $model->member->vipLevel,
            'total_score'=> $model->member->totalScore,
            'balance' => $model->member->balance,
        ];
    }
}