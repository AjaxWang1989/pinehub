<?php

namespace App\Repositories;

use App\Repositories\Traits\RepositoryRelationShip;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Activity;

/**
 * Class ActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ActivityRepositoryEloquent extends BaseRepository implements ActivityRepository
{
    use RepositoryRelationShip;
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
    public function newEventsActivity(){
        $nowTime = null;

        $nowTime = date('Y-m-d H:i:s',time());

        $this->scopeQuery(function (Activity $activity) use($nowTime){
            return $activity->where('status',Activity::HAVE_IN_HAND)
                ->where('type', Activity::NEW_EVENTS_ACTIVITY)
//                ->where('start_at', '<=', $nowTime)
//                ->where('end_at', '>', $nowTime)
                ->OrderBy('id','desc');
        });
        return $this->get()->first();
    }
}
