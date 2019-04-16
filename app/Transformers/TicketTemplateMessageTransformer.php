<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-11
 * Time: 下午5:35
 */

namespace App\Transformers;

use App\Entities\TicketTemplateMessage;
use League\Fractal\TransformerAbstract;

class TicketTemplateMessageTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['userTemplateMessage'];

    /**
     * Transform the Card entity.
     *
     * @param Ticket $model
     *
     * @return array
     */
    public function transform(TicketTemplateMessage $model)
    {
        $wechatConfig = $model->userTemplateMessage->wechatConfig;
        return [
            'id' => $model->id,
            'ticket_id' => $model->ticketId,
            'user_template_id' => $model->userTemplateId,
            'scene' => $model->scene,
            'wx_type' => WECHAT_TYPES[$wechatConfig->type],
            'is_default' => (boolean)$model->isDefault,
            'type' => $model->type
        ];
    }

    public function includeUserTemplateMessage(TicketTemplateMessage $ticketTemplateMessage)
    {
        $userTemplate = $ticketTemplateMessage->userTemplateMessage;

        $userTemplate = $this->item($userTemplate, (new UserTemplateMessageTransformer()));

        return $userTemplate;
    }
}