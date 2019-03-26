<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-19
 * Time: 下午5:12
 */

namespace App\Repositories;

use App\Entities\Advertisement;
use App\Entities\Order;
use App\Entities\User;
use App\Repositories\Traits\Destruct;
use App\Services\AppManager;
use Dingo\Api\Auth\Auth;
use InvalidArgumentException;
use Prettus\Repository\Eloquent\BaseRepository;

class AdvertisementRepositoryEloquent extends BaseRepository implements AdvertisementRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'status' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Advertisement::class;
    }

    public function getAdvertisements()
    {
        // TODO
        $advertisement = $this->scopeQuery(function (Advertisement $advertisement) {
            $currentMpUser = app(Auth::class)->user();
//            $currentMpUser = User::find(106);

            $orderId = request()->input('order_id', null);
            if (!$orderId) {
                throw new InvalidArgumentException('缺少order_id参数');
            }

            /** @var Order $order */
            $order = app(OrderRepository::class)->find($orderId);

            return $advertisement->with(['ticket.customerTickets'])
                ->where(function ($query) use ($currentMpUser) {
                    $query->where('conditions->sex', SEX_ALL)
                        ->orWhere('conditions->sex', $currentMpUser->sex);
                })
                ->where('conditions->payment_amount', '<=', $order->paymentAmount)
                ->whereAppId(app(AppManager::class)->getAppId())
                ->whereStatus(Advertisement::STATUS_ON)
                ->orderBy('created_at', 'desc');
        })->first();

        return $advertisement;
    }
}