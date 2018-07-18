<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Merchandise;
use App\Http\Requests\Admin\MerchandiseImageRequest;
use App\Http\Response\JsonResponse;

use App\Repositories\FileRepository;
use App\Services\AppManager;
use Exception;
use App\Http\Requests\Admin\MerchandiseCreateRequest;
use App\Http\Requests\Admin\MerchandiseUpdateRequest;
use App\Transformers\MerchandiseTransformer;
use App\Transformers\MerchandiseItemTransformer;
use App\Repositories\MerchandiseRepository;
use App\Http\Controllers\FileManager\UploadController as Controller;
/**
 * Class MerchandisesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class MerchandisesController extends Controller
{
    /**
     * @var MerchandiseRepository
     */
    protected $repository;


    /**
     * MerchandisesController constructor.
     *
     * @param MerchandiseRepository $repository
     * @param FileRepository $fileRepository
     */
    public function __construct(MerchandiseRepository $repository, FileRepository $fileRepository)
    {
        $this->repository = $repository;
        parent::__construct($fileRepository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchandises = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($merchandises, new MerchandiseItemTransformer());
        }

        return view('merchandises.index', compact('merchandises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MerchandiseCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(MerchandiseCreateRequest $request)
    {
        $categories = $request->input('categories');
        $data = $request->except(['categories']);
        $merchandise = $this->repository->create($data);
        tap($merchandise, function (Merchandise $merchandise) use($categories){
            $merchandise->categories()->sync($categories);
        });
        $response = [
            'message' => 'Merchandise created.',
            'data'    => $merchandise->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($merchandise, new MerchandiseTransformer());
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
        $merchandise = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($merchandise, new MerchandiseTransformer());
        }

        return view('merchandises.show', compact('merchandise'));
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
        $merchandise = $this->repository->find($id);

        return view('merchandises.edit', compact('merchandise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MerchandiseUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(MerchandiseUpdateRequest $request, $id)
    {
        $categories = $request->input('categories');
        $data = $request->except(['categories']);
        $merchandise = $this->repository->update($data, $id);
        tap($merchandise, function (Merchandise $merchandise) use($categories){
            $merchandise->categories()->sync($categories);
        });
       $response = [
           'message' => 'Merchandise updated.',
           'data'    => $merchandise->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($merchandise, new MerchandiseTransformer());
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
                'message' => 'Merchandise deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Merchandise deleted.');
    }

    public function uploadMerchandiseImage(MerchandiseImageRequest $request, string $driver="default")
    {
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $request->request->set('dir', "{$appId}/merchandise");
        return $this->upload($request, $driver);
    }

    public function __destruct()
    {
        $this->repository = null;
        parent::__destruct(); // TODO: Change the autogenerated stub
    }
}
