<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\MemberCriteria;
use App\Http\Response\JsonResponse;

use Dingo\Api\Http\Response;
use Exception;
use App\Http\Requests\Admin\MemberCreateRequest;
use App\Http\Requests\Admin\MemberUpdateRequest;
use App\Transformers\MemberTransformer;
use App\Transformers\MemberItemTransformer;
use App\Repositories\MemberRepository;
use App\Http\Controllers\Controller;

/**
 * Class MembersController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class MembersController extends Controller
{
    /**
     * @var MemberRepository
     */
    protected $repository;


    /**
     * MembersController constructor.
     *
     * @param MemberRepository $repository
     */
    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(MemberCriteria::class);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = $this->repository->paginate();
        return $this->response()->paginator($members, new MemberItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MemberCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(MemberCreateRequest $request)
    {
        $member = $this->repository->create($request->all());

        $response = [
            'message' => 'Member created.',
            'data'    => $member->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($member, new MemberTransformer());
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
        $member = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($member, new MemberTransformer());
        }

        return view('members.show', compact('member'));
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
        $member = $this->repository->find($id);

        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MemberUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(MemberUpdateRequest $request, $id)
    {
       $member = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Member updated.',
           'data'    => $member->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($member, new MemberTransformer());
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
                'message' => 'Member deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Member deleted.');
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->repository = null;
        parent::__destruct();
    }
}
