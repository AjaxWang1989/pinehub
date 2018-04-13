<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;

class UserController extends Controller
{
    protected $user = null;
    //
    /**
     * User controller construct function
     * @param UserRepository $userRepository
     * */
    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }


    public function getUsers(Request $request)
    {
        return Response::create();
    }

    public function getDetail(int $id)
    {

    }
}
