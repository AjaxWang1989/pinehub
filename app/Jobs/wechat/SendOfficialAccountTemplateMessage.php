<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-16
 * Time: 下午2:32
 */

namespace App\Jobs\wechat;

use App\Jobs\Job;
use App\Services\AppManager;
use App\Services\TemplateParser\Parser;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOfficialAccountTemplateMessage extends Job
{
    use SerializesModels;

    private $touser;
    private $templateId;
    private $data;
    private $parser;
    private $appManager;

    public function __construct(AppManager $appManager, $touser, $templateId, $data, Parser $parser)
    {
        $this->appManager = $appManager;
        $this->touser = $touser;
        $this->templateId = $templateId;
        $this->data = $data;
        $this->parser = $parser;
    }

    public function handle()
    {
        $this->parser->parse($this->data);

        app('wechat')->setAppManager($this->appManager);
        for ($i = 0; $i < 3; $i++) {
            $result = app('wechat')->officeAccount()->template_message->send([
                'touser' => $this->touser,
                'template_id' => $this->templateId,
                'data' => $this->data
            ]);
            if ($result['errcode'] === 0) {
                break;
            } else {
                if ($i === 2) {
                    Log::info('公众号模板消息未正确发送:', ['touser' => $this->touser]);
                } else {
                    Log::info('公众号模板消息未正确发送，尝试重新发送:', ['touser' => $this->touser]);
                }
            }
        }
    }
}