<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 下午3:40
 */

namespace App\Jobs\wechat;

use App\Repositories\WxTemplateMessageRepository;
use Illuminate\Support\Facades\Cache;

class OfficialAccountTemplateMessageSync extends WechatTemplateMessageSync
{
    public function handle(WxTemplateMessageRepository $wxTemplateMessageRepository)
    {
        $wxTemplateMessageRepository->deleteWhere(['wx_app_id' => $this->wxAppId]);

        $templates = $wxTemplateMessageRepository->getOfficialAccountTemplateMessages();

        foreach ($templates as $template) {
            $template['wx_app_id'] = $this->wxAppId;
            $this->parseTemplateContent($template);
            $wxTemplateMessageRepository->create($template);
        }

        Cache::forget('template_message_sync:official_account:' . $this->wxAppId);
    }
}