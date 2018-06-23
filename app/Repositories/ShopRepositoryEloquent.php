<?php

namespace App\Repositories;

use App\Entities\Country;
use App\Validators\Admin\ShopsValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Shop;

/**
 * Class ShopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopRepositoryEloquent extends BaseRepository implements ShopRepository
{
    protected $fieldSearchable = [
        'country.name',
        'province.name',
        'city.name',
        'county.name'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Shop::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        Shop::creating(function (Shop $shop) {
            $shop->code = app('uid.generator')->getUid(SHOP_CODE_FORMAT, SHOP_CODE_SEGMENT_MAX_LENGTH, ONE_DAY_SECONDS);
        });
    }

}
