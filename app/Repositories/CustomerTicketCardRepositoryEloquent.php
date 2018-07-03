<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\CustomerTicketCard;
use App\Validators\CustomerTicketCardValidator;

/**
 * Class CustomerTicketCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CustomerTicketCardRepositoryEloquent extends BaseRepository implements CustomerTicketCardRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CustomerTicketCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
