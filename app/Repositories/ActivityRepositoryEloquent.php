<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ActivityRepository;
use App\Entities\Activity;
use App\Validators\ActivityValidator;

/**
 * Class ActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ActivityRepositoryEloquent extends BaseRepository implements ActivityRepository
{
    protected $fieldSearchable = [
      'status' => '='
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Activity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function newActivity(){
        $nowTime = null;

        $nowTime = date('Y-m-d H:i:s',time());

        $this->scopeQuery(function (Activity $activity) use($nowTime){
            return $activity
                ->where('status',Activity::HAVE_IN_HAND)
                ->where('start_at', '<=', $nowTime)
                ->where('end_at', '>', $nowTime)
                ->OrderBy('id','desc');
        });
        return $this->get()->first();
    }
}
