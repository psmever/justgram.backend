<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

trait UserTrait
{
	use BaseModelTrait;

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



}