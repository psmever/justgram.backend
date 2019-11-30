<?php

namespace App\Http\Middleware;

use Closure;

class ApiBeforeMiddleware
{
	/**
	 * 요청 처리 체크
	 *
	 * TODO: 요청 체크
	 *
	 * @param $request
	 * @param Closure $next
	 * @return mixed
	 * @throws \App\Exceptions\CustomException
	 */
    public function handle($request, Closure $next)
    {
	    $clientType = $request->header('request-client-type');

	    if(empty($clientType) || !($clientType == "A02001" || $clientType == "A02002" || $clientType == "A02003"))
	    {
		    throw new \App\Exceptions\CustomException(__('auth.client_failed'));
	    }





        return $next($request);
    }
}
