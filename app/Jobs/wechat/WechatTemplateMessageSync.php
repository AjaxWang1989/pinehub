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
use Illuminate\Queue\SerializesModels;

class WechatTemplateMessageSync extends Job
{
    use SerializesModels;

    protected $wxAppId;
    protected $appManager;

    public function __construct(AppManager $appManager, $wxAppId)
    {
        $this->wxAppId = $wxAppId;
        $this->appManager = $appManager;
    }

    protected function parseTemplateContent(array &$template)
    {
        $keywords = [];
        $contentArray = explode("\n", $template['content']);
        foreach ($contentArray as $content) {
            $content = explode("{{", $content);
            if ($content[0]) {
                $keywords[] = $content[0];
            }
        }
        $template['keywords'] = $keywords;
    }
}