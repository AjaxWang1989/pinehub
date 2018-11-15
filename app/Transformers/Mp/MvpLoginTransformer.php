<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 18:25
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\MpUser;
use Carbon\Carbon;

class MvpLoginTransformer extends TransformerAbstract
{
    public function transform(MpUser $model)
    {
        return [
            'token' => $model->token,
            'nickname' => $model->nickname,
            'open_id' => $model->platformOpenId,
            'session_key' => $model->sessionKey,
            'shop_id'   => $model->shopId,
            'mobile'  => isset($model->member->mobile) ? $model->member->mobile : null,
            'can_use_score' => isset($model->member->canUseScore)  ? $model->member->canUseScore : 0,
            'ttl' => Carbon::now()->addMinute(config('jwt.ttl')),
            'refresh_ttl' => Carbon::now()->addMinute(config('jwt.refresh_ttl'))
        ];
    }
}