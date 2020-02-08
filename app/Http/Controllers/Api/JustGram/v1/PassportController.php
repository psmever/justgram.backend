<?php

namespace App\Http\Controllers\Api\JustGram\v1;

use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;
use Carbon\Carbon;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

use App\Repositories\Api\v1\PassportRepository;

class PassportController extends BaseController
{
	protected $passport;

	public function __construct(PassportRepository $passport)
	{
		$this->passport = $passport;

//		$this->middleware('guest');
//		$this->middleware('auth:api');
//		$this->middleware('auth');
	}

	/**
	 * 사용자 가입 처리
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		$result = $this->passport->attemptRegister($request);

		if($result['state'])
		{
			return $this->defaultSuccessResponse([
				'message' => __('messages.success.registed'),
				'info' => $result['data']
			]);
		}
		else
		{
			return $this->defaultErrorResponse([
				'message' => $result['message']
			]);
		}
	}

	/**
	 * 사용자 로그인 처리
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
        $result = $this->passport->attemptLogin($request);

		if($result['state'])
		{
            return $this->firstSuccessResponse([
                'data' => $result['data']
            ]);
		}
		else
		{
			return $this->defaultErrorResponse([
				'message' => __('auth.login.failed'),
				'code' => 401
			]);
		}
	}

	/**
	 * 토큰 리턴.. ( 임시 , 테스트)
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function gettoken(Request $request)
	{
		$result = $this->passport->attemptLogin($request);

		if($result['state'])
		{
			return response()->json($result['data'], 200);
		}
		else
		{
			return $this->defaultErrorResponse([
//				'message' => (isset($result['message']) && $result['message']) ? $result['message'] : __('auth.login.failed'),
				'message' => __('auth.login.failed'),
				'code' => 401
			]);
		}
	}

	public function token_refresh(Request $request)
	{
		$result = $this->passport->attemptTokenRefresh($request);

		return response()->json($result['data'], 200);
	}
}
