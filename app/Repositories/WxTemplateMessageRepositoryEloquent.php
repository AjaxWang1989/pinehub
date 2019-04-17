<?php

namespace App\Repositories;

use App\Entities\WxTemplateMessage;
use App\Jobs\wechat\MiniProgramTemplateMessageSync;
use App\Services\AppManager;
use App\Validators\WxTemplateMessageValidator;
use Illuminate\Contracts\Pagination\Paginator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class WxTemplateMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WxTemplateMessageRepositoryEloquent extends BaseRepository implements WxTemplateMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WxTemplateMessage::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * MiniProgram's template messages.
     * @return Paginator
     */
    public function getTemplateMessages(): Paginator
    {
        $wxAppId = app(AppManager::class)->miniProgram()->appId;

        $paginator = $this->scopeQuery(function (WxTemplateMessage $wxTemplateMessage) use ($wxAppId) {
            return $wxTemplateMessage->whereWxAppId($wxAppId);
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $paginator;
    }

    /**
     * OfficialAccount's template messages.
     * @return Paginator
     */
    public function getPrivateTemplateMessages(): Paginator
    {
        $wxAppId = app(AppManager::class)->officialAccount()->appId;

        $paginator = $this->scopeQuery(function (WxTemplateMessage $wxTemplateMessage) use ($wxAppId) {
            return $wxTemplateMessage->whereWxAppId($wxAppId);
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $paginator;
    }

    /**
     * Sync miniprogram's template messages.
     * @param AppManager $appManager
     */
    public function syncMiniProgram(AppManager $appManager)
    {
        $wxAppId = $appManager->miniProgram()->appId;

        $job = (new MiniProgramTemplateMessageSync($appManager, $wxAppId))->delay(1);

        dispatch($job);
    }

    /**
     * Sync official account's template messages.
     */
    public function syncOfficialAccount()
    {

    }

    public function getMiniProgramTemplateMessages($app, int $offset, int $count = PAGE_LIMIT)
    {
        app(AppManager::class)->setCurrentApp($app);
        $result = app('wechat')->miniProgram()->template_message->getTemplates($offset, $count);

        if (!$result['errcode']) {
            return $result['list'];
        }

        throw new ResourceNotFoundException($result['errmsg']);
    }

    public function getOfficialAccountTemplateMessages()
    {
        $result = app('wechat')->officeAccount()->template_message->getPrivateTemplates();

        if (isset($result['template_list'])) {
            return $result['template_list'];
        }

        throw new ResourceNotFoundException();
    }

    public function getTemplateMessagesTest()
    {
        $wxAppId = app(AppManager::class)->miniProgram()->appId;

        $this->deleteWhere(['wx_app_id' => $wxAppId]);

        $templates = [];

        $count = PAGE_LIMIT;

        for ($i = 0; ; $i++) {
            $result = $this->getMiniProgramTemplateMessages($i, $count);
            $templates = array_merge($templates, $result);
            if (count($result) < $count) {
                break;
            }
        }

        foreach ($templates as $template) {
            $template['wx_app_id'] = $wxAppId;
            $this->parseTemplateContent($template);
            $this->create($template);
        }
    }

    private function parseTemplateContent(array &$template)
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
