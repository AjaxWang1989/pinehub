<?php

namespace App\Repositories;

use App\Entities\Country;
use App\Repositories\Traits\Destruct;
use App\Validators\Admin\ShopsValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Shop;
use Illuminate\Support\Facades\DB;

/**
 * Class ShopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopRepositoryEloquent extends BaseRepository implements ShopRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'name' => 'like',
        'status' => '=',
        'country.name' => 'like',
        'province.name' => 'like',
        'city.name' => 'like',
        'county.name' => 'like',
        'country_id' => '=',
        'city_id' => '=',
        'province_id' => '=',
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

    /**
     * @param float $lng
     * @param float $lat
     * @param float $distance
     * @return Shop
     * */
    public function nearest(float $lng, float $lat, float $distance = 15){
        $this->scopeQuery(function (Shop $shop) use($lat, $lng, $distance) {
            return $shop->near($lng, $lat, $distance);
        });
        $shop = $this->first();
        if($shop)
            return $shop ;
        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }

    /**
     * @param float $lng
     * @param float $lat
     * @param float $distance
     * @return Collection|Array
     * */
    public function nearBy(float $lng, float $lat, float $distance = 15, $limit = 15) {
        $this->scopeQuery(function (Shop $shop) use($lat, $lng, $distance) {
            return $shop->near($lng, $lat, $distance);
        });
        return $this->paginate($limit);
    }

}
