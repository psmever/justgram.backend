<?php

namespace App\Http\Controllers\Api\JustGram\v1;
use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;

use Illuminate\Http\Request;

use App\Repositories\Api\v1\UserRepository;

class UserController extends BaseController
{
    protected $user;

    public function __construct(UserRepository $user)
    {
    	$this->user = $user;
    }

    /**
     * 사용자 기본 프로필 정보 전달.
     * 프로필 페이지 정보.
     *
     * @param string $user_name
     * @return void
     */
    public function profile(string $user_name) {

        $task = $this->user->checkuser($user_name);

        if($task['state'] == false) {
            return BaseController::defaultBadRequest([
				'message' => $task['message']
			]);
        }

        $task = $this->user->getUserProfileData();
        if($task['state'] == false) {
            return BaseController::defaultBadRequest([
				'message' => $task['message']
			]);
        }

        return BaseController::firstSuccessResponse([
            'data' => $task['data']
        ]);
    }
}
