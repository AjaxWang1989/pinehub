<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\UserDetailTransformer;
use App\Transformers\UsersTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;

class UsersController extends Controller
{
    protected $userModel = null;

    /**
     * User controller construct function
     * @param UserRepositoryEloquent $userRepository
     * */
    public function __construct(UserRepositoryEloquent $userRepository)
    {
        $this->userModel = $userRepository;
    }


    /**
     * 获取用户列表
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function getUsers(Request $request)
    {
        $this->userModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->userModel->with('roles.group')->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($result, new UsersTransformer);
    }

    public function getDetail(int $id)
    {
        $user = $this->userModel->with('roles.group')->find($id);
        return $this->response()->item($user, new UserDetailTransformer);
    }
}
