<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Event;
use App\Entities\MiniProgram;
use App\Events\WechatAuthAccessTokenRefreshEvent;

/**
 * Class MiniProgramRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MiniProgramRepositoryEloquent extends BaseRepository implements MiniProgramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MiniProgram::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        MiniProgram::creating(function (MiniProgram &$account) {
            $account->type = WECHAT_MINI_PROGRAM;
        });

        MiniProgram::saved(function (MiniProgram &$account) {
            Event::fire((new WechatAuthAccessTokenRefreshEvent($account))->delay($account->authorizerAccessTokenExpiresIn));
        });
    }
    
}
