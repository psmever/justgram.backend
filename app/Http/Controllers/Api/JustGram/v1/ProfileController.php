<?php

namespace App\Http\Controllers\Api\JustGram\v1;

use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Api\v1\ProfileRepository;

class ProfileController extends BaseController
{
	protected $profile;

	public function __construct(ProfileRepository $profile)
	{
		$this->profile = $profile;
	}

    /**
	 * 사용자 프로필 업데이트.
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function update(Request $request)
    {
	    $result = $this->profile->attemptUserProfileUpdate($request);

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
    public function me(Request $request)
    {
        $result = $this->profile->getProfileInfo($request);

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

    /**
     * 사용자 프로필 사진 업데이트 ( cloudinary ).
     *
     *
     * @param Request $request
     * @return void
     */
    public function image_update(Request $request)
    {
        $result = $this->profile->cloudinary_profile_image_update($request);

        if($result['state'])
	    {
		    return $this->defaultSuccessResponse([]);
	    }
	    else
	    {
		    return $this->defaultErrorResponse([
			    'message' => $result['message']
		    ]);
	    }

    }
}
