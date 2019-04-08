<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 下午3:39
 */

namespace App\Jobs\wechat;

use App\Repositories\WxTemplateMessageRepository;
use Illuminate\Support\Facades\Cache;

class MiniProgramTemplateMessageSync extends WechatTemplateMessageSync
{
    public function handle(WxTemplateMessageRepository $wxTemplateMessageRepository)
    {
        $wxTemplateMessageRepository->deleteWhere(['wx_app_id' => $this->wxAppId]);

        $templates = [];

        $count = PAGE_LIMIT;

        for ($i = 0; ; $i++) {
            $result = $wxTemplateMessageRepository->getMiniProgramTemplateMessages($i, $count);
            $templates = array_merge($templates, $result);
            if (count($result) < $count) {
                break;
            }
        }

        foreach ($templates as $template) {
            $template['wx_app_id'] = $this->wxAppId;
            $this->parseTemplateContent($template);
            $wxTemplateMessageRepository->create($template);
        }


        Cache::forget('template_message_sync:miniprogram:' . $this->wxAppId);
    }


}