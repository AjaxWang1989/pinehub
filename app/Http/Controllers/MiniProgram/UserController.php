<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\MiniProgram;


use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Repositories\WechatUserRepository;
use App\Transformers\WechatUserTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected  $wechatuserrepository = null;

    public function __construct(WechatUserRepository $wechatuserrepository)
    {
        parent::__construct();
        $this->wechatuserrepository = $wechatuserrepository;
    }

    public function registerUser(CreateRequest $request){
        $item = $this->wechatuserrepository->create($request->all());
        return $this->response()->item($item, new WechatUserTransformer());
    }
}