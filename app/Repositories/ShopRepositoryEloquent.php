<?php

namespace App\Repositories;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Country;
use App\Entities\Order;
use App\Repositories\Traits\Destruct;
use App\Repositories\Traits\RepositoryRelationShip;
use App\Validators\Admin\ShopsValidator;
use Carbon\Carbon;
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
    use Destruct, RepositoryRelationShip;
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
        'code' => 'like'
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
    public function nearest(float $lng, float $lat, float $distance = 15)
    {
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
     *
     * @return mixed
     */
    public function nearBy(float $lng, float $lat, float $distance = 15)
    {
        $this->scopeQuery(function (Shop $shop) use($lat, $lng, $distance) {
            return $shop->near($lng, $lat, $distance);
        });
        return $this->paginate();
    }


    public function withOrderCount()
    {
        return $this->withCount([
            'orders' => function (Builder $query) {
                return $query->whereIn('status', [Order::SEND, Order::COMPLETED, Order::PAID]);
            }
        ]);
    }

    public function withSellAmount()
    {
        return $this->withSum([
            'orders as sell_amount' => function (Builder $query) {
                return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                    ->whereIn('status', [Order::SEND, Order::COMPLETED, Order::PAID]);
            }
        ]);
    }

    public function withLastMonthAmount()
    {
        return $this->withSum([
            'orders as last_month_amount' => function (Builder $query) {
                $now = Carbon::now(config('app.timezone'));
                $month = $now->month - 1;
                $year = $now->year;
                $start = Carbon::create($year, $month, 1, 0, 0, 0, config('app.timezone'));
                return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                    ->where('paid_at', '>=', $start)
                    ->where('paid_at', '<', $start->copy()->endOfMonth()->endOfDay())
                    ->whereIn('status', [Order::SEND, Order::COMPLETED, Order::PAID]);
            },
        ]);
    }

    public function withThisMonthAmount()
    {
        return $this->withSum([
            'orders as this_month_amount' => function (Builder $query) {
                return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                    ->where('paid_at', '>=', Carbon::now(config('app.timezone'))
                        ->startOfMonth()->startOfDay())
                    ->where('paid_at', '<', Carbon::now(config('app.timezone')))
                    ->whereIn('status', [Order::SEND, Order::COMPLETED, Order::PAID]);
            },
        ]);
    }

    public function withMerchandiseCount()
    {
        return $this->withCount([
            'shopMerchandises' => function (Builder $query) {
                return $query->whereNotNull('status');
            }
        ]);
    }

}
