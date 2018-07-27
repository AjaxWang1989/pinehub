<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Order;
use App\Validators\Api\OrderValidator;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'type',
        'pay_type',
        'status',
        'customer_id',
        'member.mobile',
        'code'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        Order::creating(function (Order &$order){
            $order->code =  app('uid.generator')->getUid(ORDER_CODE_FORMAT, ORDER_SEGMENT_MAX_LENGTH);
            return $order;
        });
    }
}
