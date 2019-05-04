<?php

namespace App\Repositories;

use App\Entities\UserTemplateMessage;
use App\Services\AppManager;
use InvalidArgumentException;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserTemplateMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserTemplateMessageRepositoryEloquent extends BaseRepository implements UserTemplateMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserTemplateMessage::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getTemplatesViaParent(int $parentTemplateId)
    {
        $paginator = $this->scopeQuery(function (UserTemplateMessage $userTemplateMessage) use ($parentTemplateId) {
            return $userTemplateMessage->whereTemplateId($parentTemplateId);
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $paginator;
    }

    public function getTemplates(string $wxType)
    {
        $searchStr = request()->input('searchJson', null);

        $search = [];
        if ($searchStr) {
            $search = is_array($searchStr) ? $searchStr : json_decode(urldecode(base64_decode($searchStr)), true);
        }

        $appManager = app(AppManager::class);

        switch ($wxType) {
            case TEMPLATE_PLATFORM_MINIPROGRAM:
                $wxAppId = $appManager->miniProgram()->appId;
                break;
            case TEMPLATE_PLATFORM_OFFICIAL_ACCOUNT:
                $wxAppId = $appManager->officialAccount()->appId;
                break;
            default:
                throw new InvalidArgumentException("wxType必须为" . TEMPLATE_PLATFORM_MINIPROGRAM . '或者' . TEMPLATE_PLATFORM_OFFICIAL_ACCOUNT);
        }

        $paginator = $this->scopeQuery(function (UserTemplateMessage $userTemplateMessage) use ($wxAppId, $search) {
            return $userTemplateMessage->whereHas('wxTemplateMessage', function ($query) use ($search) {
                if (isset($search['title'])) {
                    $query->where('title', 'like', "%{$search['title']}%");
                }
            })->whereWxAppId($wxAppId);
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $paginator;
    }
}
