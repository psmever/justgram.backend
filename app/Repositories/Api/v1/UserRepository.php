<?php
namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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
                'phone_number' => encrypt($request->get('phone_number')),
                'gender' => $request->get('gender'),
            ]);

			if($result['state'])
			{
                $this->updateUsersProfileActive($UserData->user_uuid);

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

    /**
     * 사용저 프로필 정보 전달.
     *
     * @param Request $request
     * @return array
     */
    public function getProfileInfo(Request $request) : array
    {
        $UserData = Auth::user();

        if($UserData)
		{
            $profileInfo = $this->getUserProfileData($UserData->user_uuid);

            $data = (isset($profileInfo['data']) && $profileInfo['data']) ? $profileInfo['data'] : [];

            return [
                'state' => true,
                'data' => [
                    'user_name' => $UserData->user_name,
                    'name' => (isset($data['name']) && $data['name']) ? $data['name'] : '',
                    'web_site' => (isset($data['web_site']) && $data['web_site']) ? $data['web_site'] : '',
                    'bio' => (isset($data['bio']) && $data['bio']) ? $data['bio'] : '',
                    'phone_number' => (isset($data['phone_number']) && $data['phone_number']) ? decrypt($data['phone_number']) : '',
                    'gender' => (isset($data['gender']) && $data['gender']) ? $data['gender'] : '',
                ]
            ];
		}
		else
		{
			return [
				'state' => false,
				'message' => '잘못된 정보 입니다.'
			];
		}
    }

    public function saveProfileImage(UploadedFile $uploadedFile, $target_directory = NULL, $disk = 'public', $filename = NULL)
    {
        $targetName = !is_null($filename) ? $filename : Str::random(25);

        return $uploadedFile->storeAs($target_directory, $targetName.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
    }

    public function profile_image_update(Request $request) : array
    {
        $UserData = Auth::user();

        $validator = FacadesValidator::make($request->all(), [
			'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if( $validator->fails() )
		{
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
		}

        if($UserData)
		{
            $uploadFileName = $this->saveProfileImage($request->file('profile_image'), "/uploads/images/profile", 'public', $UserData['user_uuid']);

            if($uploadFileName)
            {
                $this->updateUserProfileImage($UserData['id'], $uploadFileName);
            }

            return [
                'state' => true,
                'data' => [
                    "file_name" => $uploadFileName,
                    "file_url" => asset("storage/".$uploadFileName)
                ]
            ];
		}
		else
		{
			return [
				'state' => false,
				'message' => '잘못된 정보 입니다.'
			];
		}


        return [

        ];

    }

}
