<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Cross
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next = null)
    {
//        if(strtoupper($request->method()) === "OPTIONS"){
//            $response = app('api.http.response')->noContent()->setStatusCode(HTTP_STATUS_NO_CONTENT);
//            $this->setHeader($response);
//        }else{
//            $response = $next($request);
//            $this->setHeader($response);
//        }
        $response = $next($request);
        Log::debug('header', $response->headers->all());
        return $response;
    }

    private function setHeader( &$response ) {
        if(!($response instanceof RedirectResponse)) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
            Log::debug('set header', $response->headers->all());
            return $response;
        }else{
            return $response;
        }

    }
}
