<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 下午3:39
 */

namespace App\Jobs\wechat;

use App\Repositories\WxTemplateMessageRepository;
use Illuminate\Support\Facades\Log;

class MiniProgramTemplateMessageSync extends WechatTemplateMessageSync
{
    public function handle(WxTemplateMessageRepository $wxTemplateMessageRepository)
    {
        Log::info('##########################Succeed...');
//        $wxTemplateMessageRepository->deleteWhere(['wx_app_id' => $this->wxAppId]);
//        Log::info('删除小程序原有模板信息完毕');
//
//        $templates = [];
//
//        $count = PAGE_LIMIT;
//
//        for ($i = 0; ; $i++) {
//            $result = $wxTemplateMessageRepository->getMiniProgramTemplateMessages($this->app, $i, $count);
//            $templates = array_merge($templates, $result);
//            if (count($result) < $count) {
//                break;
//            }
//        }
//
//        foreach ($templates as $template) {
//            $template['wx_app_id'] = $this->wxAppId;
//            $this->parseTemplateContent($template);
//            $wxTemplateMessageRepository->create($template);
//        }
//        Log::info("小程序模板消息已更新");
//
//        Cache::forget('template_message_sync:miniprogram:' . $this->wxAppId);
    }


}