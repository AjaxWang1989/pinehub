<?php

namespace App\Repositories;

use App\Events\WechatAuthAccessTokenRefreshEvent;
use Illuminate\Support\Facades\Event;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OfficialAccountRepository;
use App\Entities\OfficialAccount;
use App\Validators\OfficialAccountValidator;

/**
 * Class OfficialAccountRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OfficialAccountRepositoryEloquent extends BaseRepository implements OfficialAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OfficialAccount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        OfficialAccount::creating(function (OfficialAccount &$account) {
            $account->type = WECHAT_OFFICIAL_ACCOUNT;
        });

        OfficialAccount::saved(function (OfficialAccount &$account) {
            Event::fire((new WechatAuthAccessTokenRefreshEvent($account))->delay($account->authorizerAccessTokenExpiresIn));
        });
    }
}
