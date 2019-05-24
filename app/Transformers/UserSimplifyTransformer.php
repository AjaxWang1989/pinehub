<?php


namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class UserSimplifyTransformer extends TransformerAbstract
{
    public function transform(User $model)
    {
        return [
            'id' => (int)$model->id,
            /* place your other model properties here */
            'user_name' => $model->userName,
            'nickname' => $model->nickname,
            'mobile' => $model->mobile,
            'sex' => $model->sex,
            'avatar' => $model->avatar,
            'city' => $model->city,
            'last_login_at' => $model->lastLoginAt,
            'status' => $model->status,
            'vip_level' => $model->vipLevel,
            'created_at' => $model->createdAt
        ];
    }

}