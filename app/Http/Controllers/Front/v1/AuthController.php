<?php


namespace App\Http\Controllers\Front\v1;

use App\Http\Controllers\Front\v1\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Traits\Model\UserTrait;

class AuthController extends BaseController
{
	use UserTrait;

	public function email_auth(Request $request)
	{
		$viewData = array();

		$input = $request->only('code');

		$result = $this->getEmailAuthCodeInfo($input['code']);   // 인증 코드 조회.

		if($result['state'])
		{
			$viewData['state'] = true;

			if($result['data']['verified_at'] || $result['data']['users']['user_state'] != 'A10000') // 이미 인증 받은..
			{
				$viewData['state'] = false;
				$viewData['message'] = __('auth.email_auth.already_verified');
			}
			else if($result['data']['users']['user_active'] != 'Y') // 정상 적인 사용자가 아닐때.
			{
				$viewData['state'] = false;
				$viewData['message'] = __('auth.email_auth.user_not_active');
			}
			else
			{
				$viewData['check']['state'] = true;
			}
		}
		else
		{
			// 조회 되지 않는 인증 코드
			$viewData['state'] = false;
			$viewData['message'] = __('auth.email_auth.failed_auth_email_code');
		}

		if($viewData['state'])
		{
			if($this->doEmailAuthVertified($input['code'])) // 인증 처리.
			{
				// 인증 처기 성공.
				$viewData['state'] = true;
				$viewData['message'] = __('auth.email_auth.verified_true'); // 업데이트 시도 오류
			}
			else
			{
				// 인증 처리 실패.
				$viewData['state'] = false;
				$viewData['message'] = __('auth.email_auth.verified_false'); // 업데이트 시도 오류
			}
		}
		else
		{
			$viewData['state'] = false;
		}

//		print_r($viewData);

		return view('front.v1.auth/email_auth', $viewData);
	}
}