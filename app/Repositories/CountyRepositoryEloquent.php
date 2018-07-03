<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\County;

/**
 * Class CountyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CountyRepositoryEloquent extends BaseRepository implements CountyRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'code' => '=',
        'name' => 'like',
        'city.code' => '=',
        'city.name' => 'like',
        'province.code' => '=',
        'province.name' => 'like',
        'country.code'  => '=',
        'country.name'  => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return County::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
