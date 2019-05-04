<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 下午3:39
 */

namespace App\Jobs\wechat;

use App\Entities\WxTemplateMessage;
use App\Repositories\WxTemplateMessageRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MiniProgramTemplateMessageSync extends WechatTemplateMessageSync
{
    public function handle(WxTemplateMessageRepository $wxTemplateMessageRepository)
    {
        WxTemplateMessage::query()->update(['status' => false]);

        $templates = [];

        $count = PAGE_LIMIT;
        for ($i = 0; ; $i++) {
            $result = $wxTemplateMessageRepository->getMiniProgramTemplateMessages($this->appManager, $i, $count);
            $templates = array_merge($templates, $result);
            if (count($result) < $count) {
                break;
            }
        }

        foreach ($templates as $template) {
            $template['wx_app_id'] = $this->wxAppId;
            $this->parseTemplateContent($template);
            $templateMessage = $wxTemplateMessageRepository->firstOrNew([
                'template_id' => $template['template_id'],
                'wx_app_id' => $template['wx_app_id'],
                'title' => $template['title'],
                'content' => $template['content'],
            ]);
            $templateMessage->items = $template['items'];
            $templateMessage->status = true;
            $templateMessage->save();
            echo $templateMessage . PHP_EOL;
        }

        WxTemplateMessage::query()->where('status', false)->delete();

        Log::info("小程序模板消息已更新");

        Cache::forget('template_message_sync:miniprogram:' . $this->wxAppId);
    }
}