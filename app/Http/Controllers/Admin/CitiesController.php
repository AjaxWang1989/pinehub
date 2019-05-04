<?php

namespace App\Http\Controllers\Admin;

use App\Entities\City;
use App\Entities\Province;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\{
    CityCreateRequest, CityUpdateRequest
};
use App\Http\Response\JsonResponse;
use App\Repositories\ProvinceRepository;
use App\Transformers\CityTransformer;
use App\Transformers\CityItemTransformer;
use Dingo\Api\Facade\Route;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Router;
use Exception;
use App\Repositories\CityRepository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CitiesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CitiesController extends Controller
{
    /**
     * @var CityRepository
     */
    protected $repository;

    protected $provinceRepository;


    /**
     * CitiesController constructor.
     *
     * @param CityRepository $repository
     */
    public function __construct(CityRepository $repository, ProvinceRepository $provinceRepository)
    {
        $this->repository = $repository;
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * Display a listing of the resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id = null)
    {
        $routeName = $request->route()[1]['as'];
        switch ($routeName) {
            case 'city.list.country': {
                $this->repository->scopeQuery(function (Builder $city) use($id){
                    return $city->where('country_id', $id);
                });
                break;
            }
            case 'city.list.province': {
                $this->repository->scopeQuery(function (Builder $city) use($id){
                    return $city->where('province_id', $id);
                });
                break;
            }
            case 'city.list': {
                break;
            }
        }
        $cities = $this->repository->with(['province', 'country'])->withCount('counties')->paginate();
        return $this->response()->paginator($cities, new CityItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityCreateRequest $request
     *
     * @param int $provinceId
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CityCreateRequest $request, int $provinceId = null)
    {
        $data = $request->all();
        if($provinceId) {
            $province = $this->provinceRepository->find($provinceId);
            $data['province_id'] = $province->id;
            $data['country_id'] = $province->countryId;
        }
        $city = $this->repository->create($data);
        return $this->response()->item($city, new CityTransformer());
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
        $city = $this->repository->withCount('counties')->find($id);
        return $this->response()->item($city, new CityTransformer());
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
        $city = $this->repository->find($id);

        return view('cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CityUpdateRequest $request
     * @param  string            $id
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function update(CityUpdateRequest $request, $id)
    {
       $city = $this->repository->update($request->all(), $id);
        return $this->response()->item($city, new CityTransformer());
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
