<?php

namespace App\Repositories;

use App\Criteria\Admin\MerchandiseCriteria;
use App\Repositories\Traits\Destruct;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Merchandise;
use App\Validators\MerchandiseValidator;
use App\Repositories\Traits\RepositoryRelationShip;
use App\Criteria\Admin\SearchRequestCriteria;

/**
 * Class MerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MerchandiseRepositoryEloquent extends BaseRepository implements MerchandiseRepository
{
    use Destruct, RepositoryRelationShip;

    protected $fieldSearchable = [
        'name' => 'like',
        'sell_num'=>'*',
        'sell_price' => '*',
        'status' => '=',
        'app_id' => '=',
        'code' => 'like'
    ];
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
        Merchandise::creating(function (Merchandise $merchandise){
            $merchandise->appId = app(AppManager::class)->currentApp->id;
            $merchandise->code = app('uid.generator')->getUid(MERCHANDISE_CODE_FORMAT, MERCHANDISE_SEGMENT_MAX_LENGTH);
            return $merchandise;
        });
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findMerchandises(string $name){
        $this->scopeQuery(function (Merchandise $merchandise) use($name){
            return $merchandise->where('status', Merchandise::UP)->where('name','like','%'.$name.'%');
        });
        return $this->paginate();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function searchMerchandises(string $name){
        $this->scopeQuery(function (Merchandise $merchandise) use($name){
            return $merchandise->where('status', Merchandise::UP)->where('name','like','%'.$name.'%');
        });
        return $this->paginate();
    }
}
