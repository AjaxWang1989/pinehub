<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\AuthenticateTransformer;
use App\Validators\Auth\UserValidator;
use \Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Validator\Contracts\ValidatorInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    const RULES = [
        'mobile' => ['required', 'regex:'.MOBILE_PATTERN],
        'password' => ['required', 'regex:'.PASSWORD_PATTERN]
    ];
    const MESSAGES = [
        'mobile.required' => '缺少手机号码',
        'password.required' => '未提交密码',
        'mobile.regex' => '手机号码格式错误',
        'password.regex' => '密码格式错误'
    ];
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
     * 登录验证
     * @param Request $request
     * @return Response|null
     * @throws
     * */
    public function authenticate(Request $request)
    {
        if($this->auth()->check()){
            return $this->response()->item($this->user(), new AuthenticateTransformer);
        }else{
            if($input = $this->validate($request, self::RULES,self::MESSAGES)){
                if(!($token = JWTAuth::attempt($input))){;
                    $this->response()->error('登录密码与手机不匹配无法登录！', HTTP_STATUS_NOT_FOUND);
                }
                $user = JWTAuth::toUser($token);
                if(toUserModel($user)->status === User::FREEZE_ACCOUNT){
                    $this->response()->error('该用户已经冻结账号无法登录', HTTP_STATUS_FORBIDDEN);
                }else if(toUserModel($user)->status === User::WAIT_AUTH_ACCOUNT){
                    $this->response()->error('该用户账号尚未激活无法登录', HTTP_STATUS_FORBIDDEN);
                }
                $user->lastLoginAt = date('Y-m-d h:m:s');
                $user->save();
                return $this->response()->item($user, new AuthenticateTransformer)->withHeader('Authorization', 'Bearer '.$token);
            }
        }
        return null;
    }

    /**
     * 退出
     * @param Request $request
     * @return Response|null
     * @throws
     * */
    public function logout(Request $request)
    {
        if(JWTAuth::invalidate()){
            $response = $this->response()->noContent();
            $response->setContent(['message' => '成功退出系统']);
            return $response;
        }else{
            $this->response()->error('退出失败', HTTP_STATUS_OK);
        }
        return null;
    }

    /**
     * 注册
     * @param Request $request
     * @return Response|null
     * @throws
     * */
    public function register(Request $request)
    {
        /** @var array $user */
        if(($user = $this->userModel->makeValidator()->passesOrFail(ValidatorInterface::RULE_CREATE))){
            $user['mobile_company'] = mobileCompany($user['mobile']);
            $model = $this->userModel->create($user);
            if(!$model){
                $this->response()->error('注册失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }else{
                return $this->response()->item($model, new AuthenticateTransformer);
            }
        }
        return null;
    }
}
