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

        $provinces = $this->repository->withCount(['counties', 'cities'])->with('country')->paginate();
        return $this->response()->paginator($provinces, new ProvinceItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProvinceCreateRequest $request
     * @param int $countryId
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(ProvinceCreateRequest $request, int $countryId = null)
    {
        $data = $request->all();
        $data['country_id'] = isset($data['country_id']) && $data['country_id'] ? $data['country_id'] : $countryId;
        $province = $this->repository->create($request->all());
        return $this->response()->item($province, new ProvinceTransformer());
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
        $province = $this->repository->with('country')->withCount(['cities', 'counties'])->find($id);
        return $this->response()->item($province, new ProvinceTransformer());
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
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function update(ProvinceUpdateRequest $request, $id)
    {
       $province = $this->repository->with('country')->withCount(['cities', 'counties'])->update($request->all(), $id);
       return $this->response()->item($province, new ProvinceTransformer());
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
}
