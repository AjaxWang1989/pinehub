<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Entities\MemberCard;

/**
 * Class MemberCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberCardRepositoryEloquent extends BaseRepository implements MemberCardRepository
{
    use Destruct;

    protected $fieldSearchable = [
        'name' => ''
    ];
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
     * @throws
     */
    public function boot()
    {

    }
    
}
