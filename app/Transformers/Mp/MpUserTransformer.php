<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 1:08
 */

namespace App\Transformers\Mp;


use League\Fractal\TransformerAbstract;
use App\Entities\MpUser;
use Carbon\Carbon;

class MpUserTransformer extends TransformerAbstract
{
    public function transform(MpUser $model)
    {
        return [
            'token' => $model->token,
            'ttl' => Carbon::now()->addMinute(config('jwt.ttl')),
            'refresh_ttl' => Carbon::now()->addMinute(config('jwt.refresh_ttl'))
        ];
    }
}