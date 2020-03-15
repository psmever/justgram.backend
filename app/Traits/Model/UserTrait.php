<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


use \App\Models\JustGram\UsersMaster;
use \App\Models\JustGram\CloudinaryImageMaster;
use \App\Models\JustGram\UserProfiles;
use \App\Models\JustGram\EmailAuth;

/**
 * 사용자 관련 Trait 모음.
 * Trait UserTrait
 * @package App\Traits\Model
 */
trait UserTrait {
	// use BaseModelTrait;

    // 모델 공통 Trait
	use BaseModelTrait {
		BaseModelTrait::controlOneDataResult as controlOneDataResult;
	}

    public function test() {
        echo "UserTrait test()";
    }

	public function printQueryLog() {
		$query = DB::getQueryLog();
//		$query = end($query);
		print_r($query);
	}


	public function getEmailAuthCodeInfo(string $authCode = NULL) {
//		$result = \App\Models\JustGram\EmailAuth::whereHas('users',function (Builder $query) {
//			$query->where('user_state', 'A10000');
//			$query->where('user_active', 'Y');
//		})->where('auth_code', $authCode)->get();

		$result = EmailAuth::with('users')->where('auth_code', $authCode);

//		$this->printQueryLog();

		if($result->get()->isNotEmpty()) {
			return [
				'state' => true,
//				'data' => $result->first()->attributesToArray()
				'data' => $result->first()->toArray()
//				'data' => $result->attributesToArray()
			];
		} else {
			return [
				'state' => false
			];
		}
    }

    /**
     * 사용자 이름으로 검색 결과 전달.
     *
     * @param string $user_name
     * @return void
     */
    public function checkExitsUserName(string $user_name) {
        $taskResult = UsersMaster::where('user_name', $user_name)->get();
        if($taskResult->isNotEmpty()) {

			$userInfo = $taskResult->first();

			return [
				'state' => true,
				'data' => [
                    'user_id' => $userInfo->id,
                    'user_uuid' => $userInfo->user_uuid,
					'user_state' => $userInfo->user_state,
					'user_active' => $userInfo->user_active,
				]
			];
		} else {
			return [
				'state' => false
			];
		}
    }

	public function doEmailAuthVertified(string $authCode = NULL) : bool {
		$authInfo = EmailAuth::with('users')->where('auth_code',$authCode)->first();

		$time = \Carbon\Carbon::now();

		$authInfo->verified_at = $time;
		$authInfo->users->email_verified_at = $time;
		$authInfo->users->user_state = 'A10010';

		if($authInfo->push()) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserInfo(string $userUID = NULL) {
		$result = UsersMaster::where('user_uuid', $userUID)->get();

		if($result->isNotEmpty()) {
			$userInfo = $result->first();

			return [
				'state' => true,
				'data' => [
					'user_state' => $userInfo->user_state,
					'user_active' => $userInfo->user_active,
				]
			];
		} else {
			return [
				'state' => false
			];
		}
	}

	public function saveUserProfile(string $user_uuid, array $profileInfo) : array {
		// 있으면 업데이트 없으면 생성.
		$result = UserProfiles::updateOrCreate([
                'user_uuid' => $user_uuid
            ],[
                'name' => $profileInfo['name'],
                'web_site' => $profileInfo['web_site'],
                'bio' => $profileInfo['bio'],
                'phone_number' => $profileInfo['phone_number'],
                'gender' => $profileInfo['gender'],
            ]);

		if($result) {
			return ['state' => true];
		} else {
			return ['state' => false];
		}
    }

    public function updateUserProfileImage($user_id = NULL, $file_path = NULL) : array
    {
        $task = UsersMaster::find($user_id);

        $task->profile_image = $file_path;

        $result = $task->save();

        if($result) {
			return ['state' => true];
		} else {
			return ['state' => false];
		}
    }

    public function updateUsersProfileActive(string $user_uuid) : array
    {
        $result = UsersMaster::where("user_uuid", $user_uuid)->update(["profile_active" => "Y"]);

        if($result) {
			return ['state' => true];
		} else {
			return ['state' => false];
		}
    }

    public function getUserProfileData(string $user_uuid) : array
    {
        $result = UserProfiles::where("user_uuid", $user_uuid);

        if($result->get()->isNotEmpty()) {
            return [
                'state' => true,
                'data' => $result->first()->toArray()
            ];
        } else {
            return ['state' => false];
        }
    }

    public function secondGetUserProfileData(int $user_id) : array {

        $User = UsersMaster::find($user_id);
        $profile = $User->profile;
        $profile_image = $User->profileImage->where('image_category', 'AA22010');

        if(!$User->profile || !$User->profileImage) {
            return [
                'state' => false
            ];
        }

        $UserProfileInfo = $User->toArray();

        return [
            'state' => true,
            'data' => [
                'user_uuid' => $UserProfileInfo['user_uuid'],
                'user_name' => $UserProfileInfo['user_name'],
                'email' => $UserProfileInfo['email'],
                'profile_image' => [
                    'url' => $UserProfileInfo['profile_image']['url'],
                    'secure_url' => $UserProfileInfo['profile_image']['secure_url'],
                ],
                'count_info' => [ // 임시
                    'posts' => rand(0,100),
                    'followers' => rand(0,1000),
                    'following' => rand(0,100),
                ],
                'profile' => [
                    'name' => $UserProfileInfo['profile']['name'],
                    'web_site' => $UserProfileInfo['profile']['web_site'],
                    'bio' => $UserProfileInfo['profile']['bio'],
                    'gender' => $UserProfileInfo['profile']['gender'],
                    'phone_number' => decrypt($UserProfileInfo['profile']['phone_number']),
                ],
                'posts' => []
            ]
        ];
    }

    public function setUserProfileImageCloudinaryData(array $params) : array
    {
        // 있으면 업데이트 없으면 생성.
		$task = CloudinaryImageMaster::updateOrCreate([
                'user_uuid' => $params['user_uuid']
            ],[
                'image_category' => USER_PROFILE_IMAGE,
                'public_id' => $params['public_id'],
                'signature' => $params['signature'],
                'version' => $params['version'],
                'width' => $params['width'],
                'height' => $params['height'],
                'format' => $params['format'],
                'original_filename' => $params['original_filename'],
                'url' => $params['url'],
                'secure_url' => $params['secure_url'],
                'bytes' => $params['bytes'],
                'server_time' => $params['created_at'],
            ]);

		if($task) {
			return [
                'state' => true,
                'id' => $task->id,
            ];
		} else {
			return ['state' => false];
		}
    }

    /**
     * 사용자 프로필 업데이트.
     *
     * @param array $params
     * @return array
     */
    public function updateUsersMasterProfileImage(array $params) : array {
        $task = UsersMaster::where("user_uuid", $params['user_uuid'])->update(['profile_image' => $params['id']]);

        if($task) {
			return ['state' => true];
		} else {
			return ['state' => false];
		}
    }

    public function getUserProfileImageUrl(string $id) {
        $task = CloudinaryImageMaster::where("id", $id);

        if($task) {
            $resultArray = $task->first()->toArray();

            return [
                'state' => true,
                'data' => [
                    'url' => $resultArray["url"],
                    'secure_url' => $resultArray["secure_url"],
                ]
            ];
		} else {
			return [
                'state' => false
            ];
		}
    }
}
