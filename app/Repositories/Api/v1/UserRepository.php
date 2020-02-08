<?php
namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use App\Traits\Model\UserTrait;

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

    /**
     * 사용자 프로필 내용 업데이트.
     *
     * @param Request $request
     * @return array
     */
	public function attemptUserProfileUpdate(Request $request) : array
	{

		$UserData = Auth::user();

		if($UserData)
		{
			$validator = FacadesValidator::make($request->all(), [
                'name' => 'required',
                'web_site' => 'required',
                'bio' => 'required',
                'phone_number' => 'required',
                'gender' => 'required',
			]);

			if( $validator->fails() )
			{
				return [
					'state' => false,
					'message' => $validator->errors()
				];
			}

            $result = $this->saveUserProfile($UserData->user_uuid, [
                'name' => $request->get('name'),
                'web_site' => $request->get('web_site'),
                'bio' => $request->get('bio'),
                'phone_number' => $request->get('phone_number'),
                'gender' => $request->get('gender'),
            ]);

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
