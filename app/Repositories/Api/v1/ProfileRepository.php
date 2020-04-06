<?php

namespace App\Repositories\Api\v1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

use App\Traits\Model\UserTrait;
use App\Traits\Model\CloudinaryTrait;

class ProfileRepository implements ProfileRepositoryInterface
{
    use UserTrait,CloudinaryTrait {
        UserTrait::saveUserProfile as saveUserProfile;
    }

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
                $errorMessage = $validator->getMessageBag()->all();
				return [
					'state' => false,
					'message' => $errorMessage[0]
				];
			}

            $result = self::saveUserProfile($UserData->id, [
                'name' => $request->get('name'),
                'web_site' => $request->get('web_site'),
                'bio' => $request->get('bio'),
                'phone_number' => encrypt($request->get('phone_number')),
                'gender' => $request->get('gender'),
            ]);

			if($result['state'])
			{
                self::updateUsersProfileActive($UserData->id);

				return [
					'state' => true
				];
			}
			else
			{
				return [
					'state' => false,
					'message' => __('messages.default.error')
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
            $profileInfo = self::getUserProfileData(Auth::id());

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

    /**
     * 사용자 프로필 사진 업데이트.
     *
     * @param Request $request
     * @return void
     */
    public function cloudinary_profile_image_update(Request $request) : array
    {
        $UserData = Auth::user();

        if ($UserData) {

            $validator = FacadesValidator::make($request->all(), [
                'public_id' => 'required',
                'version' => 'required',
                'signature' => 'required',
                'width' => 'required',
                'height' => 'required',
                'format' => 'required',
                'resource_type' => 'required',
                'created_at' => 'required',
                // 'tags' => 'required',
                'bytes' => 'required',
                'type' => 'required',
                'etag' => 'required',
                'placeholder' => 'required',
                'url' => 'required',
                'secure_url' => 'required',
                'access_mode' => 'required',
                'original_filename' => 'required',
            ]);

            if ($validator->fails()) {
                $errorMessage = $validator->getMessageBag()->all();
                return [
                    'state' => false,
                    'message' => $errorMessage[0]
                ];
            }

            $params = $request->all();
            $params['user_id'] = $UserData->id;

            $result = self::setUserProfileImageCloudinaryData($params);

            if($result['state'] == true) {

                self::updateUsersMasterProfileImage([
                    "user_id" => Auth::id(),
                    "id" => $result['id']
                ]);

                return [
                    'state' => true,
                    'message' => __('messages.default.do_success')
                ];

            } else {

            }

            var_dump($result);
        } else {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }
    }

    /**
     * 프로필 이미지 업로드.
     *
     * 서버에 직접 업로드 하려고 했으나 cdn 으로 전환.
     * 그냥 csn 정보만 테이블에 저장으로 변경.
     *
     * @param Request $request
     * @return array
     */
    public function profile_image_update_bak(Request $request) : array
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
            $uploadFileName = $this->saveProfileImage($request->file('profile_image'), "/uploads/images/profile", 'public', $UserData['id']);

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
				'message' => __('messages.default.error')
			];
		}
    }

    public function profile_page_info() : array {
        $UserData = Auth::user();

        if($UserData) {


        } else {
            return [
				'state' => false,
				'message' => __('messages.default.error')
			];
        }

    }
}
