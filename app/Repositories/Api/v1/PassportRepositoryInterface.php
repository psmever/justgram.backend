<?php

namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;

interface PassportRepositoryInterface
{
	// 로그 아웃.

	public function start();
	public function attemptRegister(array $registerData);
	public function attemptLogin(Request $request);
}