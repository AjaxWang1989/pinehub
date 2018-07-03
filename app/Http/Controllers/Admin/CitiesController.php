<?php

namespace App\Http\Controllers\Admin;

use App\Entities\City;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\{
    CityCreateRequest, CityUpdateRequest
};
use App\Http\Response\JsonResponse;
use App\Transformers\CityTransformer;
use App\Transformers\CityItemTransformer;
use Dingo\Api\Facade\Route;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Router;
use Exception;
use App\Repositories\CityRepository;

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


    /**
     * CitiesController constructor.
     *
     * @param CityRepository $repository
     */
    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id)
    {
        $routeName = $request->route()[1]['as'];
        switch ($routeName) {
            case 'city.list.country': {
                $this->repository->scopeQuery(function (City $city) use($id){
                    return $city->whereCountryId($id);
                });
                break;
            }
            case 'city.list.province': {
                $this->repository->scopeQuery(function (City $city) use($id){
                    return $city->whereProvinceId($id);
                });
                break;
            }
            case 'city.list': {
                break;
            }
        }
        $cities = $this->repository->with(['province', 'country'])->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($cities, new CityItemTransformer());
        }

        return view('cities.index', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CityCreateRequest $request)
    {
        $city = $this->repository->create($request->all());

        $response = [
            'message' => 'City created.',
            'data'    => $city->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($city, new CityTransformer());
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
        $city = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($city, new CityTransformer());
        }

        return view('cities.show', compact('city'));
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
     * @return Response
     *
     * @throws Exception
     */
    public function update(CityUpdateRequest $request, $id)
    {
       $city = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'City updated.',
           'data'    => $city->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($city, new CityTransformer());
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
                'message' => 'City deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'City deleted.');
    }
}
