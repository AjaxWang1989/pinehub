<?php

namespace App\Repositories;

use App\Entities\RechargeableCard;
use App\Validators\Admin\RechargeableCardValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RechargeableCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RechargeableCardRepositoryEloquent extends BaseRepository implements RechargeableCardRepository
{
    protected $fieldSearchable = [
        'status' => '='
    ];

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
