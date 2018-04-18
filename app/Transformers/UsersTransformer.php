<?php

namespace App\Transformers;

use App\Entities\Role;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class UsersTransformer.
 *
 * @package namespace App\Transformers;
 */
class UsersTransformer extends TransformerAbstract
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
        $roles = [];
        if($model->roles){
            $model->roles->map(function (Role $role) use(&$roles){
                array_push($roles, array_merge($role->only(['id', 'slug', 'display_name']),
                    ['group' => $role->group->only('id', 'code', 'display_name')]));
            });
        }

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
            'roles'         => $roles,
            'created_at'    => $model->createdAt
        ];
    }
}
