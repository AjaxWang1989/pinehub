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
use App\Repositories\ShoppingCartRepository;
use App\Transformers\Mp\CustomerTicketCardTransformer;

class UserController extends Controller
{

    protected  $userTicketRepository;
    protected  $shoppingCartRepository;
    protected  $customerTicketCardRepository;

    /**
     * UserController constructor.
     * @param AppRepository $appRepository
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param UserTicketRepository $userTicketRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,CustomerTicketCardRepository $customerTicketCardRepository,ShoppingCartRepository $shoppingCartRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
    }

    /**
     * @param int $status
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function userTickets(int $status,Request $request){
        $request = $request->all();
        $user = $this->user();
        $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['shop_id'=>$request['store_id'],'customer_id'=>$user['id']])->sum('amount');
        $item = $this->customerTicketCardRepository->userTickets($status,$user['id'],$shoppingCartAmount);
        return $this->response()->paginator($item,new CustomerTicketCardTransformer());
    }
}