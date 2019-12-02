<?php


namespace App\Repositories\Api\v1;

use Illuminate\Support\Facades\Auth;

class ProfileRepository implements ProfileRepositoryInterface
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
				'message' => '오류'
			];
		}
	}
}