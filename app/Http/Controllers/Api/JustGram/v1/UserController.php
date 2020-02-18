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
	 * 임시 테스트용 사용자 정보.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function test()
    {
		$result = $this->user->getMeTestData();

	    if($result['state'])
	    {
		    return $this->defaultSuccessResponse([
			    'info' => $result['data']
		    ]);
	    }
	    else
	    {
		    return $this->defaultErrorResponse([
			    'message' => $result['message']
		    ]);
	    }
    }

	/**
	 * 사용자 프로필 업데이트.
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function profile_update(Request $request)
    {
	    $result = $this->user->attemptUserProfileUpdate($request);

	    if($result['state'])
	    {
		    return $this->defaultSuccessResponse([

		    ]);
	    }
	    else
	    {
		    return $this->defaultErrorResponse([
			    'message' => $result['message']
		    ]);
	    }
    }

    /**
     * 내 프로필 정보
     *
     * @param Request $request
     * @return void
     */
    public function profile_me(Request $request)
    {
        $result = $this->user->getProfileInfo($request);

        if($result['state'])
	    {
		    return $this->firstSuccessResponse([
                'data' => $result['data']
		    ]);
	    }
	    else
	    {
		    return $this->defaultErrorResponse([
			    'message' => $result['message']
		    ]);
	    }
    }

    public function profile_image_update(Request $request)
    {
        $result = $this->user->profile_image_update($request);

        if($result['state'])
	    {
		    return $this->firstSuccessResponse([
                'data' => $result['data']
		    ]);
	    }
	    else
	    {
		    return $this->defaultErrorResponse([
			    'message' => $result['message']
		    ]);
	    }

    }
}
