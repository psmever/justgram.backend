<?php

namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;

interface PostRepositoryInterface
{
	// 로그 아웃.

	public function start();
	public function attemptCreate(Request $request);
	public function attemptUpdate(Request $request);
}
