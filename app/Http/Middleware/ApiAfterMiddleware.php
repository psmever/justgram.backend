<?php

namespace App\Http\Middleware;

use Closure;

class ApiAfterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//    	echo "ApiAfterMiddleware";
//        return $next($request);

	    $response = $next($request);

	    return $response;
    }

	public function terminate($request, $response)
	{
		// TODO:: ApiAfterMiddleware terminate
	}
}
