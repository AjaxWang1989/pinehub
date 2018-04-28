<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/16
 * Time: 下午1:48
 */

namespace App\Transformers;


use App\Entities\User;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the Users entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'user_name'  => $model->userName,
            'nickname'   => $model->nickname,
            'mobile'     => $model->mobile,
            'sex'        => $model->sex,
            'avatar'     => $model->avatar,
            'city'       => $model->city,
            'last_login_at' => $model->lastLoginAt,
            'status'        => $model->status,
            'vip_level'     => $model->vipLevel,
            'roles'         => $model->roles,
            'orders'        => $model->orders,
            'created_at'    => $model->createdAt
        ];
    }
}