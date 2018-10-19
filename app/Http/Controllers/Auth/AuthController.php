<?php

namespace App\Http\Controllers\Auth;

use App\Entities\AuthSecretKey;
use App\Entities\User;
use App\Http\Response\JsonResponse;
use App\Http\Response\UpdateResponse;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\AuthenticateTransformer;
use App\Transformers\AuthPublicKeyTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\UpdateResourceFailedException;
use \Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Prettus\Validator\Contracts\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    const RULES = [
        'mobile' => ['required', 'mobile'],
        'password' => ['required', 'regex:' . PASSWORD_PATTERN]
    ];
    const MESSAGES = [
        'mobile.required' => '缺少手机号码',
        'password.required' => '未提交密码',
        'mobile.mobile' => '手机号码格式错误',
        'password.regex' => '密码格式错误'
    ];

    protected $userRepository = null;

    /**
     * User controller construct function
     * @param UserRepository $userRepository
     * */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function getPublicKey()
    {
        $item = new AuthSecretKey();
        return $this->response(new JsonResponse([
            'public_key' => $item->publicKey
        ]));
    }

    public function refreshToken()
    {
        $this->auth();
        if (Auth::getToken()) {
            $token = Auth::refresh();
            $tokenMeta = [
                'token' => $token,
                'ttl' => Carbon::now()->addMinute(config('jwt.ttl')),
                'refresh_ttl' => Carbon::now()->addMinute(config('jwt.refresh_ttl'))
            ];
            return $this->response(new JsonResponse($tokenMeta));
        } else {
            $this->response()->error('用户未登录', 400);
        }
    }

    /**
     * 登录验证
     * @param Request $request
     * @return Response|null
     * @throws
     * */
    public function authenticate(Request $request)
    {
        $user = null;
        $token = null;
        if (Auth::check()) {
            $token = Auth::refresh();
            $user = $this->user();
        } else {
            if ($input = $this->validate($request, self::RULES, self::MESSAGES)) {
                $input['app_id'] = isset($input['app_id']) ? $input['app_id'] : null;

                if (!($token = Auth::attempt($input))) {
                    $this->response()->error('登录密码与手机不匹配无法登录!',
                        HTTP_STATUS_NOT_FOUND);
                }
                $user = Auth::toUser($token);
                tap($user, function (User $user) {
                    if ($user->status === User::FREEZE_ACCOUNT) {
                        $this->response()->error('该用户已经冻结账号无法登录',
                            HTTP_STATUS_FORBIDDEN);
                    } else if (toUserModel($user)->status === User::WAIT_AUTH_ACCOUNT) {
                        $this->response()->error('该用户账号尚未激活无法登录',
                            HTTP_STATUS_FORBIDDEN);
                    }
                    $user->lastLoginAt = date('Y-m-d h:m:s');
                    $user->save();
                });
            }
        }
        $tokenMeta = [
            'token' => $token,
            'ttl' => Carbon::now()->addMinute(config('jwt.ttl')),
            'refresh_ttl' => Carbon::now()->addMinute(config('jwt.refresh_ttl'))
        ];
        app()->make('cache')->set($token, $tokenMeta, config('jwt.refresh_ttl'));
        return $this->response()->item($user, new AuthenticateTransformer)->addMeta('token', $tokenMeta);
    }

    /**
     * 退出
     * @return Response
     * @throws
     * */
    public function logout(Request $request)
    {
        if(!Auth::check()) {
            throw new HttpException(HTTP_STATUS_UNAUTHORIZED, '用户未登录', null,
                [], AUTH_NOT_LOGIN);
        }
        Auth::logout(false);
        return $this->response(new UpdateResponse('退出成功'));
    }

    public function testLogin()
    {
        return '测试';
    }
}
