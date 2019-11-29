<?php


namespace App\Repositories\Api\v1;

use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

	public function start()
	{

	}

	public function getMeTestData()
	{
		$UserData = Auth::user();

		if($UserData)
		{
			return [
				'state' => true,
				'data' => $UserData
			];
		}
		else
		{
			return [
				'state' => false,
			];
		}
	}
}