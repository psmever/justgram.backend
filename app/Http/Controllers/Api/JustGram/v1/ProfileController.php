<?php

namespace App\Http\Controllers\Api\JustGram\v1;

use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Api\v1\ProfileRepositoryInterface;

class ProfileController extends BaseController
{
	protected $profile;

	public function __construct(UserRepositoryInterface $profile)
	{
		$this->profile = $profile;
	}

    public function test()
    {
    	echo __FUNCTION__;
    }
}
