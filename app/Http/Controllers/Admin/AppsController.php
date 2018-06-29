<?php

namespace App\Http\Controllers\Admin;

use App\Transformers\AppItemTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

use App\Http\Requests\Admin\AppCreateRequest;
use App\Http\Requests\Admin\AppUpdateRequest;
use Exception;
use App\Repositories\AppRepository;

/**
 * Class AppsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class AppsController extends Controller
{
    use Helpers;
    /**
     * @var AppRepository
     */
    protected $repository;


    /**
     * AppsController constructor.
     *
     * @param AppRepository $repository
     */
    public function __construct(AppRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apps = $this->repository->paginate($request->input('limit', PAGE_LIMIT));

        if (request()->wantsJson()) {

            return $this->response()->paginator($apps, new AppItemTransformer());
        }

        return view('apps.index', compact('apps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AppCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(AppCreateRequest $request)
    {
        try {

            $app = $this->repository->create($request->all());

            $response = [
                'message' => 'App created.',
                'data'    => $app->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $app = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $app,
            ]);
        }

        return view('apps.show', compact('app'));
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
        $app = $this->repository->find($id);

        return view('apps.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AppUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(AppUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $app = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'App updated.',
                'data'    => $app->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (Exception $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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

            return response()->json([
                'message' => 'App deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'App deleted.');
    }
}
