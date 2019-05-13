<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RechargeableCardRepository;
use App\Entities\RechargeableCard;
use App\Validators\RechargeableCardValidator;

/**
 * Class RechargeableCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RechargeableCardRepositoryEloquent extends BaseRepository implements RechargeableCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RechargeableCard::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RechargeableCardValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
