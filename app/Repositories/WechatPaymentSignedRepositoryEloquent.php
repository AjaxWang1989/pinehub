<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatPaymentSignedRepository;
use App\Entities\WechatPaymentSigned;
use App\Validators\WechatPaymentSignedValidator;

/**
 * Class WechatPaymentSignedRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatPaymentSignedRepositoryEloquent extends BaseRepository implements WechatPaymentSignedRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatPaymentSigned::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
