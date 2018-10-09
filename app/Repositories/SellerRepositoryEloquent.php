<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SellerRepository;
use App\Entities\Seller;
use App\Validators\SellerValidator;

/**
 * Class SellerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SellerRepositoryEloquent extends BaseRepository implements SellerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Seller::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
