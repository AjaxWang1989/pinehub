<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 19:32
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatUser;

class WechatUserTransformer extends TransformerAbstract
{
    public function transform(WechatUser $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'app_id' => $model->appId,
            'user_id' => $model->userId,
            'wechat_app_id' => $model->wechatAppId,
            'type' => $model->type,
            'union_id' => $model->unionId,
            'open_id' => $model->openId,
            'session_key' => $model->sessionKey,
            'expires_at' => $model->expiresAt,
            'avatar' => $model->avatar,
            'country' => $model->country,
            'province' => $model->province,
            'city' => $model->city,
            'nickname' => $model->nickname,
            'sex' => $model->sex,
            'privilege' => $model->privilege,
            'create_at' => $model->createdAt,
            'updated_at' => $model->updatedAt,
            'deleted_at' => $model->deletedAt
        ];
    }
}