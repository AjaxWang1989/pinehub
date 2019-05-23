<?php


namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use App\Transformers\UserRechargeableCardConsumeRecordTransformer;
use Dingo\Api\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRechargeableCardConsumeRecordController extends Controller
{
    private $repository;

    public function __construct(UserRechargeableCardConsumeRecordRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));

        $this->repository->pushCriteria(app(SearchRequestCriteria::class));

        $paginator = $this->repository->orderBy('created_at', 'desc')->paginate($request->input('limit', PAGE_LIMIT));

        return $this->response()->paginator($paginator, new UserRechargeableCardConsumeRecordTransformer);
    }

    /**
     * 数据统计
     */
    public function statistics()
    {
        $statistics = $this->repository->getStatistics();

        return $this->response(new JsonResponse(['data' => $statistics]));
    }
}