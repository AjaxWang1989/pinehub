<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-4
 * Time: 上午10:56
 */

namespace App\Jobs\wechat;

use App\Jobs\Job;
use App\Services\AppManager;

class WechatTemplateMessageSync extends Job
{
    protected $wxAppId;

    protected $appManager;

    public function __construct(AppManager $appManager, $wxAppId)
    {
        $this->wxAppId = $wxAppId;
        $this->appManager = $appManager;
    }

    protected function parseTemplateContent(array &$template)
    {
        $items = [];
        $contentArray = explode("\n", $template['example']);
        foreach ($contentArray as $content) {
            $content = explode("：", $content);
            if ($content[0]) {
                $items[] = ['key' => $content[0], 'value' => $content[1]];
            }
        }
        $template['items'] = $items;
    }
}