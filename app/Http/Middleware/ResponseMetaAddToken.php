<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ResponseMetaAddToken
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $this->auth->guard($guard)->getToken();
        $response = $next($request);

        if($token && is_object($token)) {
            $token = $token->get();
            $token = Cache::get($token, null);
        }
        if($token) {
            return tap($response, function (&$response) use ($token){
                if($response instanceof Response){
                    $response->meta('token', $token);
                }else{
                    $data = $response->getOriginalContent();
                    $data = $data->toArray();
                    $data['token'] = $token;
                    $response->setContent($data);
                }
                return $response;
            });
        }else{
            return $response;
        }

    }
}
