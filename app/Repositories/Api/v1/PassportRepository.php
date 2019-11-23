<?php


namespace App\Repositories\Api\v1;


use App\Helpers\MasterHelper;
use App\Models\JustGram\UsersMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;



class PassportRepository implements PassportRepositoryInterface
{

	public function start()
	{

	}

	public function attemptRegister(array $registerData)
	{
		$validator = Validator::make($registerData, [
			'name' => 'required',
			'email' => 'required|email|unique:tbl_users_master',
			'password' => 'required',
			'confirm_password' => 'required|same:password',
		]);

		if( $validator->fails() )
		{
			return [
				'state' => false,
				'message' => $validator->errors()
			];
		}

		$user = UsersMaster::create([
			'user_uuid' => MasterHelper::GenerateUUID(),
			'user_type' => 'A02001',
			'name' => $registerData['name'],
			'email' => $registerData['email'],
			'password' => bcrypt($registerData['password']),
		]);

		return [
			'state' => true
		];

	}

	public function attemptLogin(array $loginData)
	{
		if(Auth::attempt(['email' => $loginData['email'], 'password' => $loginData['password']])){
			$user = Auth::user();
//			print_r($user);
//			print_r($user->user_uuid);
			$tokenResult = $user->createToken('Personal Access Token');
			$token = $tokenResult->token;

			if(isset($loginData['remember_me']) && $loginData['remember_me'])
			{
				$token->expires_at = Carbon::now()->addWeeks(1);
			}

			$token->save();


//			$response = $this->pro


			return [
				'state' => true,
				'data' => [
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
					'access_token' => $tokenResult->accessToken,
				],
			];

		} else {

			return [
				'state' => false,
				'message' => __('auth.login.failed')
			];
		}
	}
}