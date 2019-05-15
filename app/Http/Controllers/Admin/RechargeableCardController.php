<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Exceptions\HttpValidationException;
use App\Http\Controllers\Controller;
use App\Repositories\RechargeableCardRepository;
use App\Transformers\RechargeableCardTransformer;
use App\Validators\Admin\RechargeableCardValidator;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class RechargeableCardController extends Controller
{
    /**
     * @var RechargeableCardRepository $repository
     */
    private $repository;

    /**
     * @var RechargeableCardValidator $validator
     */
    private $validator;

    public function __construct(RechargeableCardRepository $repository, RechargeableCardValidator $validator)
    {
        $this->repository = $repository;

        $this->validator = $validator;

        parent::__construct();
    }

    /**
     * 卡种列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));

        $this->repository->pushCriteria(app(SearchRequestCriteria::class));

        $rechargeableCards = $this->repository->orderBy('created_at', 'desc')->paginate($request->input('limit', PAGE_LIMIT));

        return $this->response()->paginator($rechargeableCards, new RechargeableCardTransformer);
    }

    // 详情
    public function show(int $id)
    {
        $rechargeCard = $this->repository->find($id);

        return $this->response()->item($rechargeCard, new RechargeableCardTransformer);
    }

    /** 新建
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $postData = $request->post();

        try {
            $this->validator->with($postData)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $rechargeableCard = $this->repository->create($postData);
        } catch (ValidatorException $exception) {
            throw new HttpValidationException($exception->getMessageBag());
        }

        return $this->response()->item($rechargeableCard, new RechargeableCardTransformer);
    }

    /** 修改 仅允许修改 推荐位/优惠态/排序/状态
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $postData = $request->only(['is_recommend', 'on_sale', 'sort', 'status']);

        try {
            $this->validator->with($postData)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $rechargeableCard = $this->repository->update($postData, $id);
        } catch (ValidatorException $exception) {
            throw new HttpValidationException($exception->getMessageBag());
        }

        return $this->response()->item($rechargeableCard, new RechargeableCardTransformer);
    }

    /** 删除
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);

        return $this->response()->noContent();
    }
}
