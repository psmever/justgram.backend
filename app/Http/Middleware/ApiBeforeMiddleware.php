<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;


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

        //TODO: 우선 로그 저장 하기로.. 추후에 주석을 하든 세분화 해야함.
        $logid = date('Ymdhis');

        $logRoute = Route::current();
        $logRoutename = Route::currentRouteName();
        $logRouteAction = Route::currentRouteAction();

        $current_url = url()->current();
        $logHeaderInfo = json_encode($request->header());
        $logBodyInfo = json_encode($request->all());

        $logMessage = "ID:${logid} Current_url:${current_url} RouteName:${logRoutename} RouteAction:${logRouteAction} Header: {$logHeaderInfo} Body: ${logBodyInfo}";
        Log::channel('requestlog')->error($logMessage);

        return $next($request);
    }
}
