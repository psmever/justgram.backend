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
use App\Traits\OauthTrait;
use Illuminate\Support\Facades\DB;

class PassportRepository implements PassportRepositoryInterface
{
    use UserTrait, OauthTrait {
        OauthTrait::getNewToken as getNewTokenTrait;
        OauthTrait::getRefreshToken as getRefreshTokenTrait;
        UserTrait::getUserProfileImageUrl as getUserProfileImageUrlTrait;
    }

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

		if( $validator->fails() ) {
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
			'user_name' => preg_replace("/[^a-z0-9]/i", "", strtolower($request->input('username'))), // 소문자, 및 숫자만.
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password')),
        ]);

        if(!$createResult->wasRecentlyCreated) {
            return [
				'state' => false,
				'message' => __('messages.default.error')
			];
        }
        $user_id = DB::getPdo()->lastInsertId();

        $auth_code = Str::random(80);

        EmailAuth::create([
            'user_id' => $user_id,
            'auth_code' => $auth_code,
        ]);

        // TODO: 사용자 등록시 인증 메일
        $emailObject = new \stdClass();
        $emailObject->category = "user_email_auth";
        $emailObject->receiverName = $request->input('name');
        $emailObject->receiver = $request->input('email');
        $emailObject->auth_code = $auth_code;
        $emailObject->auth_url = url('/front/v1/auth/email_auth?code='.$auth_code);

        Mail::to(trim($request->input('email')))->send(new EmailMaster($emailObject));

        if(Mail::failures()) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        } else {
            return [
                'state' => true,
                'data' => [
                    'uuid' => $newUserUUID
                ]
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

        if(!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return [
				'state' => false,
				'message' => __('auth.failed')
			];
        }

        $user = Auth::user();

        $tokenResult = $this->getNewTokenTrait($request->input('email'), $request->input('password'));

        $user_name = $user['user_name'];
        $user_state = $user['user_state'];
        $user_active = $user['user_active'];
        $profile_active = $user['profile_active'];
        $profile_image = $user['profile_image'];
        $profile_image_url = NULL;

        // 사용자 상태 체크
        if($user_active != 'Y') {
            return [
                'state' => false,
                'message' => __('auth.login.not_active_user')
            ];
        }

        // 사용자 대기 체크
        if($user_state == 'A10000') {
            return [
                'state' => false,
                'message' => __('auth.login.wait_user')
            ];
        }

        if(!empty($profile_image)) {
            $profileImageResult = self::getUserProfileImageUrlTrait($profile_image);
            if($profileImageResult['state'] == true) {
                $profile_image_url = $profileImageResult["data"]["secure_url"];
            }
        }

        $returnData = [
            'token_type' => $tokenResult['token_type'],
            'expires_in' => $tokenResult['expires_in'],
            'access_token' => $tokenResult['access_token'],
            'refresh_token' => $tokenResult['refresh_token'],
            'user_name' => $user_name,
            'profile_active' => $profile_active,
            'profile_image_url' => $profile_image_url,
        ];

        return [
            'state' => true,
            'data' => $returnData
        ];
	}

	public function attemptTokenRefresh(Request $request) : array
	{
        $UserData = Auth::user();

        if (!$UserData) {
            return [
				'state' => false,
				'message' => __('auth.failed')
			];
        }

        $taskResult = self::getRefreshTokenTrait($request->input('refresh_token'));

        return [
            'state' => true,
            'data' => $taskResult
        ];
	}

}
