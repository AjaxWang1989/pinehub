<?php


namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use App\Transformers\UserRechargeableCardConsumeRecordTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Foundation\Application;
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

        $params = $request->all();

        $paginator = $this->repository->getList($params);

        return $this->response()->paginator($paginator, new UserRechargeableCardConsumeRecordTransformer);
    }

    /**
     * 数据统计
     * @param Request $request
     * @return UserRechargeableCardConsumeRecordController|Application|\Laravel\Lumen\Application|mixed
     */
    public function statistics(Request $request)
    {
        $params = $request->all();

        $statistics = $this->repository->getStatistics($params);

        return $this->response(new JsonResponse(['data' => $statistics]));
    }
}