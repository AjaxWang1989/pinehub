<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\{
    CountryCreateRequest, CountryUpdateRequest
};
use App\Http\Response\JsonResponse;
use App\Transformers\CountryItemTransformer;
use App\Transformers\CountryTransformer;
use Exception;
use App\Repositories\CountryRepository;

/**
 * Class CountriesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CountriesController extends Controller
{
    /**
     * @var CountryRepository
     */
    protected $repository;


    /**
     * CountriesController constructor.
     *
     * @param CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($countries, new CountryItemTransformer());
        }

        return view('countries.index', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CountryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CountryCreateRequest $request)
    {
        $country = $this->repository->create($request->all());

        $response = [
            'message' => 'Country created.',
            'data'    => $country->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($country, new CountryTransformer());
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
        $country = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($country, new CountryTransformer());
        }

        return view('countries.show', compact('country'));
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
        $country = $this->repository->find($id);

        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CountryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(CountryUpdateRequest $request, $id)
    {
       $country = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Country updated.',
           'data'    => $country->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($country, new CountryTransformer());
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
                'message' => 'Country deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Country deleted.');
    }
}
