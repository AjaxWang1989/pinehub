<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\MemberCard;
use App\Validators\MemberCardValidator;

/**
 * Class MemberCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberCardRepositoryEloquent extends BaseRepository implements MemberCardRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MemberCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
