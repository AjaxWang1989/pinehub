<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午2:33
 */

namespace App\Jobs\wechat;

use App\Entities\Customer;
use App\Jobs\Job;
use App\Services\AppManager;
use App\Services\TemplateParser\Parser;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * Class SendMiniprogramTemplateMessage
 * @description 发送小程序模板消息
 * @package App\Jobs\wechat
 */
class SendMiniprogramTemplateMessage extends Job
{
    use SerializesModels;

    private $customer;
    private $templateId;
    private $formId;
    private $data;
    private $parser;
    private $appManager;

    public function __construct(AppManager $appManager, Customer $customer, $templateId, $data, Parser $parser)
    {
        $this->appManager = $appManager;
        $this->customer = $customer;
        $this->templateId = $templateId;
        $this->data = $data;
        $this->parser = $parser;
    }

    public function handle()
    {
        $this->parser->parse($this->data);

        $this->getFormId();

        app('wechat')->setAppManager($this->appManager);
        while ($this->formId) {
            $result = app('wechat')->miniProgram()->template_message->send([
                'touser' => $this->customer->platformOpenId,
                'template_id' => $this->templateId,
                'form_id' => $this->formId,
                'data' => $this->data,
            ]);
            if ($result['errcode'] == 0) {
                break;
            }
            if (in_array($result['errcode'], [TEMPLATE_SEND_INVALID_FORMID, TEMPLATE_SEND_USED_FORMID])) {
                Log::info('小程序模板消息未正确发送，尝试重新发送:', [
                    'touser' => $this->customer->platformOpenId,
                    'msg' => TEMPLATE_SEND_ERRCODE[$result['errcode']],
                    'templateId' => $this->templateId,
                ]);
                $this->getFormId();
                continue;
            } else {
                Log::info('小程序模板消息未正确发送：', [
                    'touser' => $this->customer->platformOpenId,
                    'msg' => TEMPLATE_SEND_ERRCODE[$result['errcode']] ?? "未知错误代码${$result['errcode']}",
                    'templateId' => $this->templateId,
                ]);
                break;
            }
        }
    }

    private function getFormId()
    {
//        $ids = Redis::command('zpopmin', ["formid:{$this->customer->id}"]);
        $ids = Redis::command('zrange', ["formid:{$this->customer->id}", 0, 0]);
        $this->formId = count($ids) > 0 ? $ids[0] : null;
        $this->removeFormId($this->formId);
    }

    private function removeFormId($formId)
    {
        Redis::command('zrem', ["formid:{$this->customer->id}", $formId]);
    }
}