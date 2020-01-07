<?php

namespace App\Http\Controllers\Api\JustGram\v1;


use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Repositories\Api\v1\UserRepositoryInterface;

class UserController extends BaseController
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
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
}
