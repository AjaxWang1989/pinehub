<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
            header('Access-Control-Allow-Origin:*');
            header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, Accept');
            header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Credentials:true');
            return $response;
        }

    }
}
