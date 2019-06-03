<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 11:31
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\UserRechargeableCard;
use App\Entities\UserRechargeableCardConsumeRecord;
use App\Http\Requests\MiniProgram\FeedBackMessageRequest;
use App\Repositories\AppRepository;
use App\Repositories\CustomerTicketCardRepository;
use App\Repositories\FeedBackMessageRepository;
use App\Repositories\ShoppingCartRepository;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\FeedBackMessageTransformer;
use App\Transformers\Mp\UserRechargeableCardConsumeRecordTransformer;
use App\Transformers\Mp\UserRechargeableCardTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class UserController extends Controller
{
    /**
     * @var
     */
    protected $userTicketRepository;

    /**
     * @var ShoppingCartRepository
     */
    protected $shoppingCartRepository;

    /**
     * @var CustomerTicketCardRepository
     */
    protected $customerTicketCardRepository;

    /**
     * @var FeedBackMessageRepository
     */
    protected $feedBackMessageRepository;

    /**
     * UserController constructor.
     * @param AppRepository $appRepository
     * @param FeedBackMessageRepository $feedBackMessageRepository
     * @param CustomerTicketCardRepository $customerTicketCardRepository
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,
                                FeedBackMessageRepository $feedBackMessageRepository,
                                CustomerTicketCardRepository $customerTicketCardRepository,
                                ShoppingCartRepository $shoppingCartRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
        $this->feedBackMessageRepository = $feedBackMessageRepository;
    }

    /**
     * 获取用户优惠券信息
     * @param string $status
     * @param Request $request
     * @return Response
     */
    public function userTickets(string $status, Request $request)
    {
        $user = $this->mpUser();
        if ($request->input('store_id', null)) {
            $shoppingCartAmount = $this->shoppingCartRepository
                ->findWhere(['shop_id' => $request->input('store_id', null), 'customer_id' => $user['id']])
                ->sum('amount');
        } elseif ($request->input('activity_id', null)) {
            $shoppingCartAmount = $this->shoppingCartRepository
                ->findWhere(['activity_id' => $request->input('activity_id', null), 'customer_id' => $user['id']])
                ->sum('amount');
        } else {
            $shoppingCartAmount = $this->shoppingCartRepository
                ->findWhere(['activity_id' => null, 'shop_id' => null, 'customer_id' => $user['id']])
                ->sum('amount');
        }
        if (!$request->input('use', null)) {
            $items = $this->customerTicketCardRepository->userTickets($status, $user['id'], $shoppingCartAmount);
        } else {
            $items = $this->customerTicketCardRepository->userTickets($status, $user['id']);
        }

        Log::info('----------------------------card------------------', $items->toArray());
        return $this->response()->paginator($items, new CustomerTicketCardTransformer());
    }

    /**
     * 个人中心获取所有优惠券
     * @return Response
     */
    public function customerTicketCards(string $status)
    {
        $user = $this->mpUser();
        $items = $this->customerTicketCardRepository->customerTicketCards($user['id'], $status);
        return $this->response()->paginator($items, new CustomerTicketCardTransformer());
    }

    /**
     * 提交意见反馈
     * @param FeedBackMessageRequest $request
     * @return Response
     */

    public function feedBackMessage(FeedBackMessageRequest $request)
    {
        $user = $this->mpUser();

        $message = $request->all();
        $message['customer_id'] = $user['id'];
        $message['open_id'] = $user['platform_open_id'];
        $message['app_id'] = $user['app_id'];
        $item = $this->feedBackMessageRepository->create($message);
        return $this->response()->item($item, new FeedBackMessageTransformer());
    }

    /**
     * 用户持有卡片
     * @param Request $request
     * @return Response
     */
    public function customerRechargeableCards(Request $request)
    {
        $customer = $this->mpUser();

        $status = $request->get('status', null);

        if ($status) {
            $paramsShould = array_keys(UserRechargeableCard::STATUS);
            if (!in_array($status, $paramsShould)) {
                throw new InvalidArgumentException("参数status错误，应该为： " . implode('或', $paramsShould) . '中的一种');
            }
        }

        $items = $customer->rechargeableCardRecords()->with('rechargeableCard')->where(function ($query) use ($status) {
            if ($status) {
                $query->where('status', '=', $status);
            }
        })->paginate();

        return $this->response()->paginator($items, new UserRechargeableCardTransformer);
    }

    /**
     * 用户消费、购买卡片记录
     * @param Request $request
     * @return Response
     */
    public function customerRechargeableCardConsumeRecords(Request $request)
    {
        $customer = $this->mpUser();

        $type = $request->get('type', null);

        if ($type) {
            $paramsShould = array_keys(UserRechargeableCardConsumeRecord::TYPES);
            if (!in_array($type, $paramsShould)) {
                throw  new InvalidArgumentException('参数type错误，应该为：' . implode('或', $paramsShould) . '中的一种');
            }
        }

        $consumeRecords = $customer->consumeRecords()->with('rechargeableCard')->where(function ($query) use ($type) {
            if ($type) {
                $query->where('type', '=', $type);
            }
        })->groupBy(['order_id'])->selectRaw('id,type,sum(consume) as consume,sum(save) as save,created_at')
            ->orderBy('created_at', 'desc')->paginate();

        return $this->response()->paginator($consumeRecords, new UserRechargeableCardConsumeRecordTransformer);
    }

    public function userRechargeableCards()
    {

    }
}