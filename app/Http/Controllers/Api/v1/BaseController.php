<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	/**
	 * 리본 성공 응답
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function defaultSuccessResponse(array $params)
	{
		$response = [
			'message' => (isset($params['message']) && $params['message']) ? $params['message'] : __('messages.default.success')
		];


		if(isset($params['data']) && $params['data'])
		{
			$response['data'] = $params['data'];
		}

		if(isset($params['info']) && $params['info'])
		{
			$response['info'] = $params['info'];
		}

		$code = (isset($params['code']) && $params['code']) ? $params['code'] : 200;

		return response()->json($response, $code);
	}

	/**
	 * 리본 에러 응답
	 *
	 * @return \Illuminate\Http\Response
	 */
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
