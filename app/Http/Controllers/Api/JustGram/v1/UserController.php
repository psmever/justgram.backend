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
    public function profile(string $user_name)
    {

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

    /**
     * 사용자 following 리스트
     *
     * @param Request $request
     * @return void
     */
    public function following_index(Request $request, string $user_name)
    {
        $task = $this->user->makeFollowingList($user_name);
        if($task['state']) {
		    return BaseController::firstSuccessResponse([
                'data' => $task['data']
            ]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }

    /**
     * 사용자 followers 리스트
     *
     * @param Request $request
     * @return void
     */
    public function followers_index(Request $request, string $user_name)
    {
        $task = $this->user->makeFollowersList($user_name);
        if($task['state']) {
		    return BaseController::firstSuccessResponse([
                'data' => $task['data']
            ]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }

    /**
     * 사용자 팔로우 등록.
     *
     * @param Request $request
     * @return void
     */
    public function follow_create(Request $request)
    {
        $task = $this->user->create_follow($request);
        if($task['state']) {
		    return BaseController::defaultSuccessResponse([]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }

    /**
     * 사용자 팔로우 삭제.
     *
     * @param Request $request
     * @return void
     */
    public function follow_delete(Request $request)
    {
        $task = $this->user->delete_follow($request);
        if($task['state']) {
		    return BaseController::defaultSuccessResponse([]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }
}
