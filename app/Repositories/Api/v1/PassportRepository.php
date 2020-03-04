<?php
namespace App\Repositories\Api\v1;

use App\Helpers\MasterHelper;
use App\Models\JustGram\EmailAuth;
use App\Models\JustGram\UsersMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use App\Mail\v1\EmailMaster;
use Illuminate\Support\Facades\Route as FacadesRoute;

use App\Traits\Model\UserTrait;

class PassportRepository implements PassportRepositoryInterface
{
    use UserTrait;

	public function start()
	{

	}

	/**
	 * 사용자 등록.
	 * @param Request $request
	 * @return array
	 */
	public function attemptRegister(Request $request)
	{
		$validator = FacadesValidator::make($request->all(), [
            'email' => 'required|email|unique:tbl_users_master',
			'password' => 'required',
            'confirm_password' => 'required|same:password',
            'username' => 'required',
        ]);

		if( $validator->fails() )
		{
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
		}

		$newUserUUID = MasterHelper::GenerateUUID();

		$createResult = UsersMaster::create([
			'user_uuid' => $newUserUUID,
			'user_type' => $request->header('request-client-type'),
			'user_name' => $request->input('username'),
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

	/**
	 * 사용자 로그인.
	 * @param Request $request
	 * @return array
	 */
	public function attemptLogin(Request $request) : array
	{
		if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            $user_name = $user['user_name'];
			$user_state = $user['user_state'];
            $user_active = $user['user_active'];
            $profile_active = $user['profile_active'];
            $profile_image = $user['profile_image'];

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
				'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
				'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
				'username' => $request->input('email'),
				'password' => $request->input('password'),
				'scope' => '',
			]);

			$tokenRequest = $request->create(
				url('/api/v1/oauth/token'),
				'post'
            );

            if($tokenRequest) {
                $data = json_decode(FacadesRoute::dispatch($tokenRequest)->getContent());
                $data->user_name = $user_name;
                $data->profile_active = $profile_active;
                $data->profile_image_url = NULL;

                if(!empty($profile_image)) {
                    $profileImageResult = self::getUserProfileImageUrl($profile_image);
                    if($profileImageResult['state'] == true) {
                        $data->profile_image_url = $profileImageResult["data"]["secure_url"];
                    }
                }

                return [
                    'state' => true,
                    'data' => $data
                ];

            } else {
                return [
                    'state' => false,
                    'message' => __('auth.failed')
                ];
            }

		} else {
			return [
				'state' => false,
				'message' => __('auth.failed')
			];
		}
	}

	public function attemptTokenRefresh(Request $request) : array
	{
		$UserData = Auth::user();

		if($UserData)
		{
			$request->request->add([
				'grant_type' => 'refresh_token',
				'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
				'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
				'refresh_token' => $request->input('refresh_token'),
				'scope' => '',
			]);

			$tokenRequest = $request->create(
				url('/api/v1/oauth/token'),
				'post'
			);

			return [
				'state' => true,
				'data' => json_decode(FacadesRoute::dispatch($tokenRequest)->getContent())
			];
        }

		return [
			'state' => true
		];

	}

}
