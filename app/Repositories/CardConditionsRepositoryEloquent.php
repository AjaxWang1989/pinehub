<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CardConditionsRepository;
use App\Entities\CardConditions;
use App\Validators\CardConditionsValidator;

/**
 * Class CardConditionsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CardConditionsRepositoryEloquent extends BaseRepository implements CardConditionsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CardConditions::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
