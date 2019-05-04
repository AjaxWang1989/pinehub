<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 14:46
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\App;


class AppAccessTransformer extends TransformerAbstract
{
    public function transform(App $model)
    {
        return [
            'access_token' => $model['access_token'],
            'contact_phone_num' => $model->contactPhoneNum,
            'logo' => $model->logo,
            'app_id' => $model->id,
            'ttl' => $model->ttl
        ];
    }
}