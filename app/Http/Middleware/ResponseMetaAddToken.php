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
        $response = $next($request);

        if($token && is_object($token)) {
            $token = $token->get();
            $token = Cache::get($token, null);
        }

        if(!$token) {
            return $response;
        }else{
            return tap($response, function (&$response) use ($token){
                Log::debug('response ', [$response->getContent()]);
                $data = json_decode($response->getContent(), true);
                if($data) {
                    $data['token'] = $token;
                    $content = json_encode($data);
                    $response->setContent($content);
                }
                return $response;
            });
        }
    }
}
