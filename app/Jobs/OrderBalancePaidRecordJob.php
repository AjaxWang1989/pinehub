<?php
/**
 * OrderBalancePaidRecord.php
 * User: katherine
 * Date: 19-5-20 下午3:10
 */

namespace App\Jobs;

use App\Entities\Order;
use App\Entities\UserRechargeableCard;
use App\Repositories\OrderRepository;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use App\Repositories\UserRechargeableCardRepository;
use Illuminate\Support\Facades\Log;

/**
 * Class OrderBalancePaidRecord
 * 订单余额支付任务类
 * @desc 记录余额消费明细
 * @package App\Jobs
 */
class OrderBalancePaidRecordJob extends Job
{
    /**
     * @var array 消费明细
     */
    protected $consumeRecords;

    protected $orderId;

    public function __construct(int $orderId, array $consumeRecords)
    {
        $this->orderId = $orderId;
        $this->consumeRecords = $consumeRecords;
    }

    public function handle(OrderRepository $orderRepository,
                           UserRechargeableCardConsumeRecordRepository $consumeRecordRepository,
                           UserRechargeableCardRepository $userRechargeableCardRepository)
    {
        /** @var Order $order */
        $order = $orderRepository->find($this->orderId);

        if (in_array($order->status, [Order::PAID, Order::SEND, Order::COMPLETED])) {
            foreach ($this->consumeRecords as $consumeRecord) {
                Log::info('余额消费记录：', [$consumeRecord]);
                $consumeRecord['order_id'] = $this->orderId;
                $consumeRecordRepository->create($consumeRecord);
                /** @var UserRechargeableCard $userRechargeableCardRecord */
                $userRechargeableCardRecord = $userRechargeableCardRepository->find($consumeRecord['user_rechargeable_card_id']);
                $userRechargeableCardRecord->update(['amount' => $userRechargeableCardRecord->amount - $consumeRecord['consume']]);
            }
        }
    }
}