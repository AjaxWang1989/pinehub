<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\CustomerCriteria;
use App\Entities\Role;
use App\Http\Requests\Admin\{
    CustomerCreateRequest, CustomerUpdateRequest
};
use App\Http\Response\JsonResponse;
use App\Transformers\CustomerItemTransformer;
use App\Transformers\CustomerTransformer;
use Exception;
use App\Repositories\UserRepository as CustomerRepository;
use App\Http\Controllers\Controller;
/**
 * Class CustomersController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class CustomersController extends Controller
{
    /**
     * @var CustomerRepository
     */
    protected $repository;

    const ROLE_SLUG = [Role::CUSTOMER, Role::MEMBER];


    /**
     * CustomersController constructor.
     *
     * @param CustomerRepository $repository
     */
    public function __construct(CustomerRepository $repository)
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
        $this->repository->pushCriteria(CustomerCriteria::class);
        $customers = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($customers, new CustomerItemTransformer());
        }

        return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(CustomerCreateRequest $request)
    {
        $customer = $this->repository->create($request->all());

        if ($request->wantsJson()) {

            return $this->response()->item($customer, new CustomerTransformer());
        }

        return redirect()->back()->with('message', '创建成功');
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
        $customer = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($customer, new CustomerTransformer());
        }

        return view('customers.show', compact('customer'));
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
        $customer = $this->repository->find($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
       $customer = $this->repository->update($request->all(), $id);

       if ($request->wantsJson()) {

           return $this->response()->item($customer, new CustomerTransformer());
       }

       return redirect()->back()->with('message', 'Customer update success');
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
                'message' => 'Customer deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Customer deleted.');
    }
}
