<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;
use Carbon\Carbon;

use App\Repositories\Api\v1\PassportRepositoryInterface;

class PassportController extends BaseController
{
	protected $passport;

	public function __construct(PassportRepositoryInterface $passport)
	{
		$this->passport = $passport;

		$this->middleware('guest');
//		$this->middleware('auth:api');
//		$this->middleware('auth');
	}

	public function register(Request $request)
	{

		$result = $this->passport->attemptRegister($request->all());

		if($result['state'])
		{
			return $this->defaultSueecssResponse([
				'message' => __('messages.success.registed')
			]);
		}
		else
		{
			return $this->defaultErrorResponse([
				'message' => $result['message']
			]);
		}
	}

	public function login(Request $request)
	{
		$result = $this->passport->attemptLogin($request->all());

		if($result['state'])
		{
			return $this->defaultSueecssResponse([
				'message' => __('auth.login.success'),
				'data' => $result['data'],
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

}
