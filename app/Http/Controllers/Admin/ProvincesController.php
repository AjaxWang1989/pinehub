<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Province;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\{
    ProvinceCreateRequest, ProvinceUpdateRequest
};
use App\Http\Response\JsonResponse;
use App\Transformers\ProvinceTransformer;
use App\Transformers\ProvinceItemTransformer;
use Exception;
use App\Repositories\ProvinceRepository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProvincesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class ProvincesController extends Controller
{
    /**
     * @var ProvinceRepository
     */
    protected $repository;


    /**
     * ProvincesController constructor.
     *
     * @param ProvinceRepository $repository
     */
    public function __construct(ProvinceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param int $countryId
     * @return \Illuminate\Http\Response
     */
    public function index(int $countryId = null)
    {

        if($countryId) {
            $this->repository->scopeQuery(function (Builder $province) use($countryId) {
                return $province->where('country_id', $countryId);
            });
        }

        $provinces = $this->repository->with(['country'])->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($provinces, new ProvinceItemTransformer());
        }

        return view('provinces.index', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProvinceCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(ProvinceCreateRequest $request)
    {
        $province = $this->repository->create($request->all());

        $response = [
            'message' => 'Province created.',
            'data'    => $province->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($province, new ProvinceTransformer());
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
        $province = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($province, new ProvinceTransformer());
        }

        return view('provinces.show', compact('province'));
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
        $province = $this->repository->find($id);

        return view('provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProvinceUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(ProvinceUpdateRequest $request, $id)
    {
       $province = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Province updated.',
           'data'    => $province->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($province, new ProvinceTransformer());
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
                'message' => 'Province deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Province deleted.');
    }
}
