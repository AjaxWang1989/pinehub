<?php

namespace App\Repositories;

use App\Criteria\Admin\OrderGiftCriteria;
use App\Services\AppManager;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\OrderGift;

/**
 * Class OrderGiftRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderGiftRepositoryEloquent extends BaseRepository implements OrderGiftRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        new OrderGift();
        return OrderGift::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(OrderGiftCriteria::class);
//        OrderGift::creating(function (OrderGift $gift) {
//            $gift->appId = app(AppManager::class)->currentApp->id;
//            return $gift;
//        });
    }

}
