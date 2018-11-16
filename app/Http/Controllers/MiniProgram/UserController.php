<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 11:31
 */

namespace App\Http\Controllers\MiniProgram;
use App\Repositories\AppRepository;
use Dingo\Api\Http\Request;
use App\Repositories\UserTicketRepository;
use App\Repositories\CustomerTicketCardRepository;
use App\Repositories\FeedBackMessageRepository;
use App\Repositories\ShoppingCartRepository;
use App\Transformers\Mp\CustomerTicketCardTransformer;
use App\Transformers\Mp\FeedBackMessageTransformer;
use App\Http\Requests\MiniProgram\FeedBackMessageRequest;
use App\Exceptions\UserCodeException;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var
     */
    protected  $userTicketRepository;

    /**
     * @var ShoppingCartRepository
     */
    protected  $shoppingCartRepository;

    /**
     * @var CustomerTicketCardRepository
     */
    protected  $customerTicketCardRepository;

    /**
     * @var FeedBackMessageRepository
     */
    protected  $feedBackMessageRepository;

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

        $this->shoppingCartRepository       = $shoppingCartRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
        $this->feedBackMessageRepository    = $feedBackMessageRepository;
    }

    /**
     * 获取用户优惠券信息
     * @param int $status
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function userTickets(int $status,Request $request){
        $request = $request->all();
        $user = $this->mpUser();
        if (isset($request['store_id']) && $request['store_id']){
            $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['shop_id'=>$request['store_id'],'customer_id'=>$user['id']])->sum('amount');
        } elseif (isset($request['activity_id']) && $request['activity_id']){
            $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['activity_id'=>$request['activity_id'],'customer_id'=>$user['id']])->sum('amount');
        }else{
            $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['activity_id'=>null,'shop_id'=>null,'customer_id'=>$user['id']])->sum('amount');
        }
        $items = $this->customerTicketCardRepository->userTickets($status,$user['id'], $shoppingCartAmount);

        return $this->response()->paginator($items,new CustomerTicketCardTransformer());
    }

    /**
     * 个人中心获取所有优惠券
     * @return \Dingo\Api\Http\Response
     */
    public function customerTicketCards(int $status)
    {
        $user = $this->mpUser();
        $items = $this->customerTicketCardRepository->customerTicketCards($user['id'],$status);
        return $this->response()->paginator($items,new CustomerTicketCardTransformer());
    }

    /**
     * 提交意见反馈
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */

    public function feedBackMessage(FeedBackMessageRequest $request){
        $user = $this->mpUser();

        $message = $request->all();
        $message['customer_id'] = $user['id'];
        $message['open_id'] = $user['platform_open_id'];
        $message['app_id'] = $user['app_id'];
        $item = $this->feedBackMessageRepository->create($message);
        return $this->response()->item($item,new FeedBackMessageTransformer());
    }
}