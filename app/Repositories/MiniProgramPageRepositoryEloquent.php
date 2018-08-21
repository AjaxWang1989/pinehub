<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MiniProgramPageRepository;
use App\Entities\MiniProgramPage;
use App\Validators\MiniProgramPageValidator;

/**
 * Class MiniProgramPageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MiniProgramPageRepositoryEloquent extends BaseRepository implements MiniProgramPageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MiniProgramPage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
