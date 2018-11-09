<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\ScoreRuleCriteria;
use App\Entities\ScoreRule;
use App\Http\Response\JsonResponse;

use App\Services\AppManager;
use Exception;
use App\Http\Requests\Admin\ScoreRuleCreateRequest;
use App\Http\Requests\Admin\ScoreRuleUpdateRequest;
use App\Transformers\ScoreRuleTransformer;
use App\Transformers\ScoreRuleItemTransformer;
use App\Repositories\ScoreRuleRepository;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class ScoreRulesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class ScoreRulesController extends Controller
{
    /**
     * @var ScoreRuleRepository
     */
    protected $repository;


    /**
     * ScoreRulesController constructor.
     *
     * @param ScoreRuleRepository $repository
     */
    public function __construct(ScoreRuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function index(string $type = null)
    {
        $this->repository->pushCriteria(ScoreRuleCriteria::class);
        if($type === 'general') {
            $this->repository->scopeQuery(function ($scoreRule) {
                return $scoreRule->where('type', ScoreRule::GENERAL_RULE);
            });
        }elseif ($type === 'special') {
            $this->repository->scopeQuery(function ($scoreRule) {
                return $scoreRule->where('type', '>=', ScoreRule::SPECIAL_RULE);
            });
        }
        $scoreRules = $this->repository->paginate();
        return $this->response()->paginator($scoreRules, new ScoreRuleItemTransformer());
    }


    public function specialRules() {
        return $this->index('special');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  ScoreRuleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(ScoreRuleCreateRequest $request)
    {
        $data = $request->all();
        $scoreRule = $this->repository->create($data);
        return $this->response()->item($scoreRule, new ScoreRuleTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scoreRule = $this->repository->find($id);
        return $this->response()->item($scoreRule, new ScoreRuleTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $scoreRule = $this->repository->find($id);

        return view('scoreRules.edit', compact('scoreRule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ScoreRuleUpdateRequest $request
     * @param  string            $id
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function update(ScoreRuleUpdateRequest $request, $id)
    {
       $scoreRule = $this->repository->update($request->all(), $id);
       return $this->response()->item($scoreRule, new ScoreRuleTransformer());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return $this->response(new JsonResponse(['delete_count' => $deleted]));
    }


    public function generalRule()
    {
        $scoreRule = $this->repository->findByField('type', ScoreRule::GENERAL_RULE)->first();
        if($scoreRule) {
            return $this->response()->item($scoreRule, new ScoreRuleTransformer());
        }else{
            throw new ResourceNotFoundException('尚未添加通用积分规则', MODEL_NOT_FOUND);
        }

    }
}
