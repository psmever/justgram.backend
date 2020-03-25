<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // TODO: Passport::routes
	    Passport::routes(function ($router) {
		    $router->forAccessTokens();
		    $router->forPersonalAccessTokens();
		    $router->forTransientTokens();
	    }, ['prefix' => 'api/v1/oauth']);

	    // TODO: TokenTime Test...
        // Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::tokensExpireIn(Carbon::now()->addDays(1));
	    Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));

//	    Passport::tokensExpireIn(Carbon::now()->addMinutes(1));
//	    Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(2));
    }
}
