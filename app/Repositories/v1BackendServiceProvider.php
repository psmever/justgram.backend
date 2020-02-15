<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class v1BackendServiceProvider extends ServiceProvider
{

	public function register()
	{
        // 인증 처리
		$this->app->bind(
			'App\Repositories\Api\v1\PassportRepositoryInterface',
			'App\Repositories\Api\v1\PassportRepository'
		);

        // 사용자 관련.
		$this->app->bind(
			'App\Repositories\Api\v1\UserRepositoryInterface',
			'App\Repositories\Api\v1\UserRepository'
        );

        // 시스템 관련.
        $this->app->bind(
            'App\Repositories\Api\v1\SystemRepositoryInterface',
			'App\Repositories\Api\v1\SystemRepository'
        );
	}
}
