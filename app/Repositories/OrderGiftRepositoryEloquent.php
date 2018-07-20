<?php

namespace App\Repositories;

use App\Criteria\Admin\OrderGiftCriteria;
use App\Services\AppManager;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderGiftRepository;
use App\Entities\OrderGift;
use App\Validators\OrderGiftValidator;

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
        OrderGift::creating(function (OrderGift $gift) {
            $gift->appId = app(AppManager::class)->currentApp->id;
            return $gift;
        });
    }

}
