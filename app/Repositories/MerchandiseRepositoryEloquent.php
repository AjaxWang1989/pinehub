<?php

namespace App\Repositories;

use App\Criteria\Admin\MerchandiseCriteria;
use App\Repositories\Traits\Destruct;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Merchandise;
use App\Validators\MerchandiseValidator;

/**
 * Class MerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MerchandiseRepositoryEloquent extends BaseRepository implements MerchandiseRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Merchandise::class;
    }



    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
//        $this->pushCriteria(app(MerchandiseCriteria::class));
        Merchandise::creating(function (Merchandise $merchandise){
            $merchandise->appId = app(AppManager::class)->currentApp->id;
            $merchandise->code = app('uid.generator')->getUid(MERCHANDISE_CODE_FORMAT, MERCHANDISE_SEGMENT_MAX_LENGTH);
            return $merchandise;
        });
    }

}
