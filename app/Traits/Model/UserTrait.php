<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * 사용자 관련 Trait 모음.
 * Trait UserTrait
 * @package App\Traits\Model
 */
trait UserTrait
{
	// use BaseModelTrait;

    // 모델 공통 Trait
	use BaseModelTrait {
		BaseModelTrait::controlOneDataResult as controlOneDataResult;
	}

	public function __construct()
	{
		DB::enableQueryLog();
	}

	public function __destruct()
	{
//		echo "1";
	}

	public function printQueryLog()
	{
		$query = DB::getQueryLog();
//		$query = end($query);
		print_r($query);
	}


	public function getEmailAuthCodeInfo(string $authCode = NULL)
	{
//		$result = \App\Models\JustGram\EmailAuth::whereHas('users',function (Builder $query) {
//			$query->where('user_state', 'A10000');
//			$query->where('user_active', 'Y');
//		})->where('auth_code', $authCode)->get();

		$result = \App\Models\JustGram\EmailAuth::with('users')->where('auth_code', $authCode);

//		$this->printQueryLog();

		if($result->get()->isNotEmpty())
		{
			return [
				'state' => true,
//				'data' => $result->first()->attributesToArray()
				'data' => $result->first()->toArray()
//				'data' => $result->attributesToArray()
			];
		}
		else
		{
			return [
				'state' => false
			];
		}
	}

	public function doEmailAuthVertified(string $authCode = NULL) : bool
	{
		$authInfo = \App\Models\JustGram\EmailAuth::with('users')->where('auth_code',$authCode)->first();

		$time = \Carbon\Carbon::now();

		$authInfo->verified_at = $time;
		$authInfo->users->email_verified_at = $time;
		$authInfo->users->user_state = 'A10010';

		if($authInfo->push())
		{
			return true;
		}
		else
		{
			return false;
		}


	}

	public function getUserInfo(string $userUID = NULL)
	{
		$result = \App\Models\JustGram\UsersMaster::where('user_uuid', $userUID)->get();

		if($result->isNotEmpty())
		{
			$userInfo = $result->first();

			return [
				'state' => true,
				'data' => [
					'user_state' => $userInfo->user_state,
					'user_active' => $userInfo->user_active,
				]
			];
		}
		else
		{
			return [
				'state' => false
			];
		}
	}

	public function saveUserProfile(string $user_uuid, array $profileInfo) : array
	{
		// 있으면 업데이트 없으면 생성.
		$result = \App\Models\JustGram\UserProfiles::updateOrCreate(
			[
                'user_uuid' => $user_uuid
            ],[
                'name' => $profileInfo['name'],
                'web_site' => $profileInfo['web_site'],
                'bio' => $profileInfo['bio'],
                'phone_number' => $profileInfo['phone_number'],
                'gender' => $profileInfo['gender'],
            ]);

		if($result)
		{
			return ['state' => true];
		}
		else
		{
			return ['state' => false];
		}
    }

    public function updateUsersProfileActive(string $user_uuid)
    {
        $result = \App\Models\JustGram\UsersMaster::where("user_uuid", $user_uuid)->update(["profile_active" => "Y"]);

        if($result)
		{
			return ['state' => true];
		}
		else
		{
			return ['state' => false];
		}
    }

    public function getUserProfileData(string $user_uuid) : array
    {
        $result = \App\Models\JustGram\UserProfiles::where("user_uuid", $user_uuid);

        if($result->get()->isNotEmpty())
		{
            return [
                'state' => true,
                'data' => $result->first()->toArray()
            ];
        }
        else
        {
            return ['state' => false];
        }
    }




}
