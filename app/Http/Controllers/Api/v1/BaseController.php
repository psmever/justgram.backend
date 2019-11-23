<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	/**
	 * success response method.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function defaultSueecssResponse(array $params)
	{
		$response = [
			'message' => (isset($params['message']) && $params['message']) ? $params['message'] : __('messages.default.success')
		];


		if(isset($params['data']) && $params['data'])
		{
			$response['data'] = $params['data'];
		}

		$code = (isset($params['code']) && $params['code']) ? $params['code'] : 200;

		return response()->json($response, $code);
	}


	/**
	 * return error response.
	 *
	 * @return \Illuminate\Http\Response
	 */
//	public function defaultErrorResponse($error, $errorMessages = [], $code = 404)
	public function defaultErrorResponse(array $params)
	{


		if(isset($params['message']) && $params['message'])
		{
			$response['message'] = $params['message'];
		}
		else
		{
			$response['error'] = __('messages.default.error');
		}

		$code = (isset($params['code']) && $params['code']) ? $params['code'] : 401;

		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}

		return response()->json($response, $code);
	}
}
