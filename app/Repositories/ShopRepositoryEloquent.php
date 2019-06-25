<?php

namespace App\Repositories;

use App\Entities\Order;
use App\Entities\Shop;
use App\Repositories\Traits\Destruct;
use App\Repositories\Traits\RepositoryRelationShip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;

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
        'code' => 'like',
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
        $this->scopeQuery(function (Shop $shop) use ($lat, $lng, $distance) {
            return $shop->whereStatus(Shop::STATUS_OPEN)->near($lng, $lat, $distance);
        });
        $shop = $this->first();
        if ($shop)
            return $shop;
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
        $this->scopeQuery(function (Shop $shop) use ($lat, $lng, $distance) {
            return $shop->whereHas('shopManager')->whereStatus(Shop::STATUS_OPEN)->near($lng, $lat, $distance);
        });
        return $this->paginate();
    }


    public function withOrderCount(array $params = [])
    {
        return $this->withCount([
            'orders' => function (Builder $query) use ($params) {
                return $query->whereIn('status', [Order::SEND, Order::COMPLETED, Order::PAID]);
            }
        ]);
    }

    public function withSellAmount(array $params = [])
    {
        return $this->withSum([
            'orders as sell_amount' => function (Builder $query) use ($params) {
                if ($params && isset($params['paid_at']) && is_array($params['paid_at']) && count($params['paid_at']) >= 2) {
                    $query->whereDate('paid_at', '>=', $params['paid_at'][0])
                        ->whereDate('paid_at', '<', $params['paid_at'][1]);
                }
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


    /**
     * @param int $id
     * @return Shop
     * */
    public function todayOrderInfo(int $id)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now();
        Log::debug('--------- date time -------', [$start, $end]);
        /** @var Shop $shop */
        $shop = $this->scopeQuery(function (Shop $shop) use ($start, $end) {

            return $shop->withCount([
                'orders as order_num' => function (Builder $query) use ($start, $end) {
                    return $query->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                },

                'orders as payment_amount' => function (Builder $query) use ($start, $end) {
                    return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                        ->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                },
                'orders as ali_payment_amount' => function (Builder $query) use ($start, $end) {
                    return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                        ->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->where('pay_type', Order::ALI_PAY)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                },
                'orders as wechat_payment_amount' => function (Builder $query) use ($start, $end) {
                    return $query->select(DB::raw('sum(payment_amount) as payment_amount'))
                        ->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->where('pay_type', Order::WECHAT_PAY)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                },
                'orders as self_pick_order_num' => function (Builder $query) use ($start, $end) {
                    return $query->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->where('pick_up_method', Order::USER_SELF_PICK_UP)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                },
                'orders as need_send_order_num' => function (Builder $query) use ($start, $end) {
                    return $query->where('paid_at', '>=', $start)
                        ->where('paid_at', '<', $end)
                        ->where('pick_up_method', Order::SEND_ORDER_TO_USER)
                        ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED]);
                }
            ]);
        })->find($id);

        $shop['buyer_num'] = $shop->orders()->where('paid_at', '>=', $start)
            ->where('paid_at', '<', $end)
            ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED])
            ->groupBy('customer_id')->get();
        $shop['buyer_num'] = count($shop['buyer_num']);

        return $shop;
    }

}
