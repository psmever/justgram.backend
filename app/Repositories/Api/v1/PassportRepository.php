<?php


namespace App\Repositories\Api\v1;


use App\Helpers\MasterHelper;
use App\Models\JustGram\EmailAuth;
use App\Models\JustGram\UsersMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use GuzzleHttp\Client;
use App\Mail\v1\EmailMaster;


class PassportRepository implements PassportRepositoryInterface
{

	public function start()
	{

	}

	public function attemptRegister(Request $request)
	{
		$validator = Validator::make($request->all(), [
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

		$newUserUUID = MasterHelper::GenerateUUID();

		$createResult = UsersMaster::create([
			'user_uuid' => $newUserUUID,
			'user_type' => $request->header('request-client-type'),
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password')),
		]);

		if($createResult->wasRecentlyCreated)
		{
			$auth_code = Str::random(80);

			EmailAuth::create([
				'user_uuid' => $newUserUUID,
				'auth_code' => $auth_code,
			]);

			// TODO: 사용자 등록시 인증 메일
			$emailObject = new \stdClass();
			$emailObject->category = "user_email_auth";
			$emailObject->receiverName = $request->input('name');
			$emailObject->receiver = $request->input('email');
			$emailObject->auth_code = $auth_code;
			$emailObject->auth_url = url('/front/v1/auth/email_auth?code='.$auth_code);

			Mail::to("psmever@gmail.com")->send(new EmailMaster($emailObject));

			if(Mail::failures())
			{
				return [
					'state' => false,
					'message' => __('messages.default.error')
				];
			}
			else
			{
				return [
					'state' => true,
					'data' => [
						'uuid' => $newUserUUID
					]
				];
			}

		}
		else
		{
			return [
				'state' => false,
				'message' => __('messages.default.error')
			];
		}
	}

	public function attemptLogin(Request $request)
	{

		if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

			$user = Auth::user();

			$user_state = $user['user_state'];
			$user_active = $user['user_active'];

			if($user_active != 'Y') // 사용자 상태 체크
			{
				return [
					'state' => false,
					'message' => __('auth.login.not_active_user')
				];
			}

			if($user_state == 'A10000') // 사용자 대기 체크
			{
				return [
					'state' => false,
					'message' => __('auth.login.wait_user')
				];
			}


			// request 를 생성해서 해야 하는데 그게 안됨.. 이유를 모르겠음.. 무한 뻉뻉이 돔?
			$request->request->add([
				'grant_type' => 'password',
				'client_id' => "2",
				'client_secret' => "q7vTZEbH6Le5cw0tcxW0kKTeLkkHaBGQR945zSWt",
				'username' => $request->input('email'),
				'password' => $request->input('password'),
				'scope' => '',
			]);

			$tokenRequest = $request->create(
				url('/api/v1/oauth/token'),
				'post'
			);


			return [
				'state' => true,
				'data' => json_decode(\Route::dispatch($tokenRequest)->getContent())
			];


		} else {
			return [
				'state' => false,
				'message' => __('auth.failed')
			];
		}




//		if(Auth::attempt(['email' => $loginData['email'], 'password' => $loginData['password']])){
//			$user = Auth::user();
//			$tokenResult = $user->createToken('Personal Access Token');
//			$token = $tokenResult->token;
//
//			if(isset($loginData['remember_me']) && $loginData['remember_me'])
//			{
//				$token->expires_at = Carbon::now()->addWeeks(1);
//			}
//
//			$token->save();
//
//			return [
//				'state' => true,
//				'data' => [
//					'token_type' => 'Bearer',
//					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
//					'access_token' => $tokenResult->accessToken,
//				],
//			];
//
//		} else {
//
//			return [
//				'state' => false,
//				'message' => __('auth.login.failed')
//			];
//		}
	}
}