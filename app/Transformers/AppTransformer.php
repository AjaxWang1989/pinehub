<?php

namespace App\Transformers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Entities\App;
use phpDocumentor\Reflection\Project;

/**
 * Class AppTransformer.
 *
 * @package namespace App\Transformers;
 */
class AppTransformer extends TransformerAbstract
{
    /**
     * Transform the App entity.
     *
     * @param \App\Entities\App $model
     *
     * @return array
     */
    public function transform(App $model)
    {
        return [
            'id'         => $model->id,
            'name' => $model->name,
            'mini_app_id' => $model->miniAppId,
            'wechat_app_id' => $model->wechatAppId,
            'secret' => $model->secret,
            'logo' => $model->logo,
            'concat_phone_num' => $model->concatPhoneNum,
            'concat_name' => $model->contactName,
            /* place your other model properties here */
            'shop_count' => $model->shopsCount,
            'order_count' => $model->ordersCount,
            'new_user_count' => $model->newUserCount,
            'active_user_count' => $model->activeUserCount,
            'refunding_order_count' => 0,
            'open_platform_auth_url' => buildUrl('web.wxopen', 'auth', [], [
                'app_id' => $model->id, 'token' =>  (string)app('tymon.jwt.auth')->getToken(), 'type' => 'all'
            ]),
            'official_account_auth_url' => buildUrl('web.wxopen', 'auth', [], [
                'app_id' => $model->id, 'token' =>  (string)app('tymon.jwt.auth')->getToken(), 'type' => 'official_account'
            ]),
            'mini_program_auth_url' => buildUrl('web.wxopen', 'auth', [], [
                'app_id' => $model->id, 'token' =>  (string)app('tymon.jwt.auth')->getToken(), 'type' => 'mini_program'
            ]),
            'mini_program' => $model->miniProgram,
            'official_account' => $model->officialAccount,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt,
        ];
    }
}
