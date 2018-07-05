<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Dingo\Api\Http\Response;
use Illuminate\Contracts\Auth\Factory as Auth;
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
        Log::debug('request type ', [$request]);
        if(!$token) {
            return $next($request);
        }
        if(is_object($token)) {
            $token = $token->get();
        }
        $token = Cache::get($token, null);
        Log::debug('token ', [$token]);
        if(!$token) {
            return $next($request);
        }
        return with($next($request), function ($response) use ($token){
            Log::debug('response type', [$response]);
            $data = json_decode($response->getContent(), true);
            if($data) {
                $data['meta']['token'] = $token;
                $content = json_encode($data);
                $response->setContent($content);
            }

            return Response::create($response->getContent());
        });
    }
}
