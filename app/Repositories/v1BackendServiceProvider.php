<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class v1BackendServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->bind(
			'App\Repositories\Api\v1\PassportRepositoryInterface',
			'App\Repositories\Api\v1\PassportRepository'
		);
	}
}