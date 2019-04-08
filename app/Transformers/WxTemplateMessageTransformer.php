<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 下午2:04
 */

namespace App\Transformers;

use App\Entities\WxTemplateMessage;
use League\Fractal\TransformerAbstract;

class WxTemplateMessageTransformer extends TransformerAbstract
{
    public function transform(WxTemplateMessage $model)
    {
        return [
            'id' => $model->id,
            'wx_app_id' => $model->wxAppId,
            'template_id' => $model->templateId,
            'title' => $model->title,
            'primary_industry' => $model->primaryIndustry,
            'deputy_industry' => $model->deputyIndustry,
            'items' => $model->items,
            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt,
        ];
    }
}