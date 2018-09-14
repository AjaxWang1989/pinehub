<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Repositories\Traits\Destruct;
use Illuminate\Support\Facades\DB;
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
        'orderItemMerchandise.name',
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
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(SearchRequestCriteria::class);
        Order::creating(function (Order &$order){
            $order->code =  app('uid.generator')->getUid(ORDER_CODE_FORMAT, ORDER_SEGMENT_MAX_LENGTH);
            return $order;
        });
    }

    /**
     * @param $data
     * @return bool
     */
    public function insertMerchandise($itemMerchandises)
    {
        $item = DB::table('order_item_merchandises')->insert($itemMerchandises);
        return $item;
    }

    /**
     * @param $sendTime
     * @param $userId
     * @param string $limit
     * @return mixed
     */

    public function storeBuffetOrders($sendTime,$userId,$limit = '15')
    {
        $this->scopeQuery(function (Order $order) use($userId,$sendTime) {
            return $order->with('orderItemMerchandises')->where(['shop_id'=>$userId])->whereRaw("send_time >= '".$sendTime['send_start_time']."' AND send_time <= '".$sendTime['send_end_time']."' AND type =3 OR type =1");
        });
        return $this->paginate($limit);
    }

    /**
     * @param $sendTime
     * @param $userId
     * @param string $limit
     * @return mixed
     */
    public function storeSendOrders($sendTime,$userId,$limit = '15')
    {
        $this->scopeQuery(function (Order $order) use($userId,$sendTime) {
            return $order->with('orderItemMerchandises')->where(['shop_id'=>$userId])->whereRaw("send_time >= '".$sendTime['send_start_time']."' AND send_time <= '".$sendTime['send_end_time']."' AND type =2 OR type =4");
        });
        return $this->paginate($limit);
    }

    /**
     * @param string $status
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function allOrders(string $status,int $userId,$limit = '15')
    {
        $this->scopeQuery(function (Order $order) use($status,$userId){
            return $order->with('orderItemMerchandises')->where(['shop_id'=>$userId,'status'=>$status]);
        });
        return $this->paginate($limit);
    }


    public function storeOrdersSummary(array $request,int $userId,$limit = '15')
    {
        $this->scopeQuery(function (Order $order) use($userId,$request) {
            return $order->with('orderItemMerchandises')->where(['shop_id'=>$userId])->whereRaw("send_time >= '".$request['send_start_time']."' AND send_time <= '".$request['send_end_time']."' AND type = '".$request['type']."' AND status = '".$request['status']."'");
        });
        return $this->paginate($limit);
    }
}
