<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 18:25
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\WechatUser;
use Carbon\Carbon;

class MvpLoginTransformer extends TransformerAbstract
{
    public function transform(WechatUser $model)
    {
        return [
            'token' => $model->token,
            'ttl' => Carbon::now()->addMinute(config('jwt.ttl')),
            'refresh_ttl' => Carbon::now()->addMinute(config('jwt.refresh_ttl'))
        ];
    }
}