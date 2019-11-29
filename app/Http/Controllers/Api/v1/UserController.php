<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Api\v1\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Repositories\Api\v1\UserRepositoryInterface;

class UserController extends BaseController
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
    	$this->user = $user;
    }

    public function me()
    {
		$result = $this->user->getMeTestData();

	    if($result['state'])
	    {
		    return $this->defaultSueecssResponse([
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
