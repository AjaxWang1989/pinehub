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
use http\Exception\InvalidArgumentException;
use Prettus\Repository\Eloquent\BaseRepository;

class AdvertisementRepositoryEloquent extends BaseRepository implements AdvertisementRepository
{
    use Destruct;
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
        return Advertisement::class;
    }

    public function getAdvertisements()
    {
        // TODO
        $advertisements = $this->scopeQuery(function (Advertisement $advertisement) {
//            $currentMpUser = app(Auth::class)->user();
            $currentMpUser = User::find(106);

            $orderId = request()->input('orderId', null);
            if (!$orderId) {
                throw new InvalidArgumentException('缺少orderId参数');
            }

            /** @var Order $order */
            $order = app(OrderRepository::class)->find($orderId);

            return $advertisement->where(function ($query) use ($currentMpUser) {
                $query->where('conditions->sex', SEX_ALL)
                    ->orWhere('conditions->sex', $currentMpUser->sex);
            })->where('conditions->payment_amount', '<=', $order->paymentAmount)
//                ->whereAppId(app(AppManager::class)->getAppId())
                ->whereAppId('2018090423350000')
                ->whereStatus(Advertisement::STATUS_ON)
                ->orderByDesc('created_at')
                ->orderByDesc('updated_at');
        })->paginate(request()->input('limit', PAGE_LIMIT));

        return $advertisements;
    }
}