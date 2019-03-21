<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MiniProgramDraftRepository;
use App\Entities\MiniProgramDraft;
use App\Validators\MiniProgramDraftValidator;

/**
 * Class MiniProgramDraftRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MiniProgramDraftRepositoryEloquent extends BaseRepository implements MiniProgramDraftRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MiniProgramDraft::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
