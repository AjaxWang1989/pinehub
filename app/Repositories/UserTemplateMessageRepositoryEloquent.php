<?php

namespace App\Repositories;

use function foo\func;
use Illuminate\Pagination\Paginator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\UserTemplateMessage;

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
}
