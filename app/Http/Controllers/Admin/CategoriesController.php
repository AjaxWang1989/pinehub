<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\CategoryCriteria;
use App\Criteria\Admin\SearchRequestCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryItemTransformer;
use App\Transformers\CategoryTransformer;
use Dingo\Api\Http\Request;
use Exception;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Response;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(CategoryCriteria::class);

        $this->repository->pushCriteria(SearchRequestCriteria::class);

        $categories = $this->repository->paginate($request->input('limit', PAGE_LIMIT));

        return $this->response()->paginator($categories, new CategoryItemTransformer());
    }

    public function all()
    {
        $this->repository->pushCriteria(CategoryCriteria::class);

        $this->repository->pushCriteria(SearchRequestCriteria::class);

        $categories = $this->repository->all();

        return $this->response()->collection($categories, new CategoryTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     *
     * @return Response
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
     * @param int $id
     *
     * @return Response
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
     * Get single resource by specified key.(Key is unique in database.)
     * @param Request $request
     * @return Response
     */
    public function showByKey(Request $request)
    {
        if (!$request->has('key')) {
            throw  new InvalidArgumentException('缺失必要参数key');
        }
        $key = $request->get('key');

        $category = $this->repository->findByField('key', $key);

        return $this->response()->item($category, new CategoryTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param string $id
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
            'data' => $category->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($category, new CategoryTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
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
