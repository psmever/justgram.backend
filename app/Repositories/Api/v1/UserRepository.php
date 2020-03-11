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

    private $UserUUID;
    private $UserID;

	public function start() {

    }

    /**
     * 사용자 체크.
     *
     * @param string $user_name
     * @return array
     */
    public function checkUser(string $user_name = NULL) : array {

        if(empty($user_name)) {
            return [
                "state" => false,
                "message" => __('messages.exits_value.user'),
            ];
        }

        $checkResult = self::checkExitsUserName($user_name);

        if ($checkResult['state'] == false) {
            return [
                "state" => false,
                "message" => __('messages.exits.user'),
            ];
        }
        //TODO: 사용자 상태 체크를 어떻게 할지?

        $this->UserUUID = $checkResult['data']['user_uuid'];
        $this->UserID = $checkResult['data']['user_id'];

        return [
            "state" => true,
        ];
    }

    /**
     * 사용자 프로필 정보 전달.
     *
     * @return void
     */
    public function getUserProfileData() {
        $taskResult = self::secondGetUserProfileData($this->UserID);
        if($taskResult['state']) {
            return [
                'state' => true,
                'data' => $taskResult['data']
            ];
        } else {
            return [
                'state' => true,
                'message' => __('messages.exits.data'),
            ];
        }
    }
}
