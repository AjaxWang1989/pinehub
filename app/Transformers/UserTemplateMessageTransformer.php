<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-4
 * Time: 上午11:05
 */

namespace App\Transformers;

use App\Entities\UserTemplateMessage;
use League\Fractal\TransformerAbstract;

class UserTemplateMessageTransformer extends TransformerAbstract
{
    public function transform(UserTemplateMessage $model)
    {
        $parentTemplate = $model->wxTemplateMessage;

        return [
            'id' => $model->id,
            'wx_app_id' => $model->wxAppId,
            'type' => $model->type,
            'template_id' => $model->templateId,
            'content' => $model->content,
            // wechat miniprogram template message
            'parent' => $parentTemplate,

            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt,
        ];
    }

    private function keywordsGenerate(array $parentKeywords, array $content)
    {
        $keywords = [];
        foreach ($parentKeywords as $key => $parentKeyword) {
        }
        return $keywords;
    }
}