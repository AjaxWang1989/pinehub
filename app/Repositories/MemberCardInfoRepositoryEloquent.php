<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\MemberCardInfo;

/**
 * Class MemberCardInfoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberCardInfoRepositoryEloquent extends CardRepositoryEloquent implements MemberCardInfoRepository
{
    protected $fieldSearchable = [
        'card_info->title' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MemberCardInfo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }
    
}
