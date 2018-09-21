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
use App\Transformers\Mp\UserTicketsTransformer;

class UserController extends Controller
{
    protected  $userTicketRepository;
    public function __construct(AppRepository $appRepository,UserTicketRepository $userTicketRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->userTicketRepository = $userTicketRepository;
    }


    public function userTickets(int $status){
        $user = $this->user();
        $userId = $user['member_id'];
        $item = $this->userTicketRepository->userTickets($status,$userId);
        return $this->response()->paginator($item,new UserTicketsTransformer());
    }
}