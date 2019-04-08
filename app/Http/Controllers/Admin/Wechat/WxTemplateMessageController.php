<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-2
 * Time: 上午11:44
 */

namespace App\Http\Controllers\Admin\Wechat;

use App\Http\Controllers\Controller;
use App\Repositories\WxTemplateMessageRepository;
use App\Services\AppManager;
use App\Transformers\WxTemplateMessageTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class WxTemplateMessageController extends Controller
{
    /**
     * @var WxTemplateMessageRepository $wxTemplateMessageRepository
     */
    private $wxTemplateMessageRepository;

    public function __construct(WxTemplateMessageRepository $wxTemplateMessageRepository)
    {
        $this->wxTemplateMessageRepository = $wxTemplateMessageRepository;
        parent::__construct();
    }

    /**
     * Sync miniprogram's template messages with db.
     */
    public function syncMiniProgram()
    {
        $wxAppId = app(AppManager::class)->miniProgram()->appId;

        $syncStatus = Cache::get('template_message_sync:miniprogram:' . $wxAppId);

        if ($syncStatus) {
            return $this->response(['status' => 'sync', 'msg' => '正在同步中']);
        }

        Cache::put('template_message_sync:miniprogram:' . $wxAppId, true, 1);

        $this->wxTemplateMessageRepository->syncMiniProgram();

        return $this->response(['status' => 'accepted', 'msg' => '已处理，正在同步中']);
    }

    /**
     * Miniprogram's template messages sync status check.
     */
    public function syncMiniProgramCheck()
    {
        $wxAppId = app(AppManager::class)->miniProgram()->appId;

        $syncStatus = Cache::get('template_message_sync:miniprogram:' . $wxAppId);

        if ($syncStatus) {
            return $this->response(['status' => 'sync', 'msg' => '正在同步中']);
        }
        return $this->response(['status' => 'sync_end', 'msg' => '已同步']);
    }

    /**
     * Sync official account's template messages with db.
     */
    public function syncOfficialAccount()
    {
        $wxAppId = app(AppManager::class)->officialAccount()->appId;

        $syncStatus = Cache::get('template_message_sync:official_account:' . $wxAppId);

        if ($syncStatus) {
            return $this->response(['status' => 'sync', 'msg' => '正在同步中']);
        }

        Cache::put('template_message_sync:official_account:' . $wxAppId, true, 1);

        $this->wxTemplateMessageRepository->syncOfficialAccount();

        return $this->response(['status' => 'accepted', 'msg' => '已处理，正在同步中']);
    }

    public function syncOfficialAccountCheck()
    {
        $wxAppId = app(AppManager::class)->officialAccount()->appId;

        $syncStatus = Cache::get('template_message_sync:official_account:' . $wxAppId);

        if ($syncStatus) {
            return $this->response(['status' => 'sync', 'msg' => '正在同步中']);
        }
        return $this->response(['status' => 'sync_end', 'msg' => '已同步']);
    }

    /**
     * Get all official wechat template messages.
     */
    public function privateTemplates()
    {
        $templates = $this->wxTemplateMessageRepository->getPrivateTemplateMessages();

        return $this->response()->paginator($templates, new WxTemplateMessageTransformer());
    }

    /**
     * Get all miniprogram template messages.
     * @return \Dingo\Api\Http\Response
     */
    public function templates()
    {
        $templates = $this->wxTemplateMessageRepository->getTemplateMessages();

        return $this->response()->paginator($templates, new WxTemplateMessageTransformer());
    }

    public function templatesTest()
    {
        $this->wxTemplateMessageRepository->getTemplateMessagesTest();
    }
}