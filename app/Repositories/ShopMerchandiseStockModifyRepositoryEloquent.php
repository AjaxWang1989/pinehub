<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 16:00
 */

namespace App\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\ShopMerchandiseStockModify;
use App\Validators\ShopMerchandiseStockModifyValidator;


class ShopMerchandiseStockModifyRepositoryEloquent extends BaseRepository implements ShopMerchandiseStockModifyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopMerchandiseStockModify::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}