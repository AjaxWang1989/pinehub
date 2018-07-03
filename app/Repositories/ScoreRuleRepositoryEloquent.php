<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\ScoreRule;
use App\Validators\ScoreRuleValidator;

/**
 * Class ScoreRuleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ScoreRuleRepositoryEloquent extends BaseRepository implements ScoreRuleRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ScoreRule::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
