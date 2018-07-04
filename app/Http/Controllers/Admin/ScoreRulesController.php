<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\ScoreRuleCriteria;
use App\Entities\ScoreRule;
use App\Http\Response\JsonResponse;

use Exception;
use App\Http\Requests\Admin\ScoreRuleCreateRequest;
use App\Http\Requests\Admin\ScoreRuleUpdateRequest;
use App\Transformers\ScoreRuleTransformer;
use App\Transformers\ScoreRuleItemTransformer;
use App\Repositories\ScoreRuleRepository;
use App\Http\Controllers\Controller;

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
            $this->repository->findWhere(['type'=> ScoreRule::GENERAL_RULE]);
        }elseif ($type === 'special') {
            $this->repository->findWhere(['type' => ['>', ScoreRule::SPECIAL_RULE]]);
        }
        $scoreRules = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($scoreRules, new ScoreRuleItemTransformer());
        }

        return view('scoreRules.index', compact('scoreRules'));
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
        $scoreRule = $this->repository->create($request->all());

        $response = [
            'message' => 'ScoreRule created.',
            'data'    => $scoreRule->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($scoreRule, new ScoreRuleTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
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

        if (request()->wantsJson()) {

            return $this->response()->item($scoreRule, new ScoreRuleTransformer());
        }

        return view('scoreRules.show', compact('scoreRule'));
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
     * @return Response
     *
     * @throws Exception
     */
    public function update(ScoreRuleUpdateRequest $request, $id)
    {
       $scoreRule = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'ScoreRule updated.',
           'data'    => $scoreRule->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($scoreRule, new ScoreRuleTransformer());
       }

       return redirect()->back()->with('message', $response['message']);
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

        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => 'ScoreRule deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'ScoreRule deleted.');
    }
}
