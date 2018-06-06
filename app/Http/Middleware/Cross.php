<?php

namespace App\Http\Middleware;

use Closure;

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
        $response = $next($request);
        $this->setHeader($response);
        return $response;
    }

    private function setHeader( &$response ) {
        if(method_exists($response, 'header')) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
            return $response;
        }else{
            return $response;
        }

    }
}
