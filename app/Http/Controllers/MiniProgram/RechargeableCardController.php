<?php
/**
 * RechargeableCardController.php
 * User: katherine
 * Date: 19-5-17 下午1:45
 */

namespace App\Http\Controllers\MiniProgram;

use App\Repositories\AppRepository;
use App\Repositories\RechargeableCardRepository;
use App\Transformers\Mp\RechargeableCardTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use http\Exception\InvalidArgumentException;

class RechargeableCardController extends Controller
{
    private $repository;

    public function __construct(Request $request, AppRepository $appRepository, RechargeableCardRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($request, $appRepository);
    }

    /**
     * 列表 | 推荐列表
     * 如果参数中有amount（实际付款金额），返回用户余额（balance，通过计算得到）和推荐列表，
     * 否则返回正常储值列表，若参数中有card_type（卡片类型），则返回相应类型卡片，否则，返回全部卡片
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (!$request->has('amount') && !$request->has('card_type')) {
            throw new InvalidArgumentException();
        }

        $params = $request->only(['amount', 'card_type']);

        $user = $this->mpUser();

        $rechargeableCards = $this->repository->getList($user, $params);

        return $this->response()->collection($rechargeableCards, new RechargeableCardTransformer);
    }

//    /**
//     * 购买卡片
//     * @param int $id 被购买卡片的ID
//     * @return Response
//     */
//    public function buy(int $id)
//    {
//        $user = $this->mpUser();
//
//        $rechargeableCard = $this->repository->find($id);
//
//        $userRechargeableCard = $this->repository->buy($user, $rechargeableCard);
//
//        return $this->response()->item($userRechargeableCard, new UserRechargeableCardTransformer);
//    }
//
//    /**
//     * 卡片余额消费
//     * @param Request $request
//     * @return Response
//     */
//    public function consume(Request $request)
//    {
//        $user = $this->mpUser();
//
//        if (!$request->has('amount')) {
//            throw new InvalidArgumentException('缺少实际消费金额');
//        }
//
//        $amount = $request->input('amount');
//
//        $consumeRecord = $this->repository->consume($user, $amount);
//
//        return $this->response()->item($consumeRecord, new UserRechargeableCardConsumeRecord);
//    }
}