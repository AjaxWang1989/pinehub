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

class WechatAuthController extends Controller
{
    protected  $wechatuserrepository = null;

    public function __construct(WechatUserRepository $wechatuserrepository)
    {
        parent::__construct();
        $this->wechatuserrepository = $wechatuserrepository;
    }

    public function registerUser(CreateRequest $request){
        $wechatUser = $this->wechatuserrepository->create($request->all());
        $param = array('open_id'=>$wechatUser['open_id'],'session_key'=>$wechatUser['session_key']);
        $token = Auth::login($wechatUser);
        return $this->response()->item($token, new WechatUserTransformer());
    }

    public function userInfo(string $openid){
        $item = $this->wechatuserrepository->find($openid,'open_id');
        return $this->response()->item($item, new WechatUserTransformer());
    }


}