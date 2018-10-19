<?php

namespace App\Http\Controllers\Admin;

use App\Http\Response\JsonResponse;

use Exception;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Transformers\CategoryTransformer;
use App\Transformers\CategoryItemTransformer;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;

/**
 * Class CategoriesController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $repository;


    /**
     * CategoriesController constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->paginate();

        return $this->response()->paginator($categories, new CategoryItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = $this->repository->create($request->all());
        return $this->response()->item($category, new CategoryTransformer());
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
        $category = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($category, new CategoryTransformer());
        }

        return view('categories.show', compact('category'));
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
        $category = $this->repository->find($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
       $category = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Category updated.',
           'data'    => $category->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($category, new CategoryTransformer());
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
                'message' => 'Category deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Category deleted.');
    }
}
