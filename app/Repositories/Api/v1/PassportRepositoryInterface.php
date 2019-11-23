<?php

namespace App\Repositories\Api\v1;

use http\Env\Request;

interface PassportRepositoryInterface
{
	public function start();
	public function attemptRegister(array $registerData);
	public function attemptLogin(array $loginData);
}