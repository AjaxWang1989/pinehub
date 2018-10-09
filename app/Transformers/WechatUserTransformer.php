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
            'token' => $model['token']
        ];
    }
}