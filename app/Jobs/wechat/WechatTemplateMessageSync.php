<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-4
 * Time: 上午10:56
 */

namespace App\Jobs\wechat;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;

class WechatTemplateMessageSync extends Job
{
    use SerializesModels;

    protected $app;
    protected $wxAppId;

//    public function __construct($app, $wxAppId)
    public function __construct($wxAppId)
    {
//        $this->app = $app;
        $this->wxAppId = $wxAppId;
//        Log::info('APP@@@@@@@@@@@@@@@@：', [$app]);
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