<?php


namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Model\UserTrait;
use Validator;

class UserRepository implements UserRepositoryInterface
{
	use UserTrait;

	public function start()
	{

	}

	/**
	 * 사용자 정보 (테스트)
	 * @return array
	 */
	public function getMeTestData()
	{
		$UserData = Auth::user();

		if($UserData)
		{
			return [
				'state' => true,
				'data' => $UserData
			];
		}
		else
		{
			return [
				'state' => false,
				'message' => '오류'
			];
		}
	}


	public function attemptUserProfileUpdate(Request $request) : array
	{

		$UserData = Auth::user();

		if($UserData)
		{

			$validator = Validator::make($request->all(), [
				'real_name' => 'required',
			]);

			if( $validator->fails() )
			{
				return [
					'state' => false,
					'message' => $validator->errors()
				];
			}


			$input = $request->only(
				'real_name',
				'web_site',
				'about',
				'telephone',
				'gender'
			);

			$result = $this->saveUserProfile($UserData->user_uuid, $input);

			if($result['state'])
			{
				return [
					'state' => true
				];
			}
			else
			{
				return [
					'state' => false,
					'message' => _('messages.default.error')
				];
			}


		}
		else
		{
			return [
				'state' => false,
				'message' => '잘못된 정보 입니다.'
			];

		}




	}

}