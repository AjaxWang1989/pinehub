<?php

namespace App\Repositories;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Validators\UserRechargeableCardConsumeRecordValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRechargeableCardConsumeRecordRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRechargeableCardConsumeRecordRepositoryEloquent extends BaseRepository implements UserRechargeableCardConsumeRecordRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserRechargeableCardConsumeRecord::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return UserRechargeableCardConsumeRecordValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
