<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->loadEnvironmentFrom('.env.testing');

        return $app;
    }

    public static function getDefaultHeaders()
    {
        return [
            'Request-Client-Type' => 'A02001',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    public static function getAuthHeaders(string $access_token)
    {
        return [
            'Request-Client-Type' => 'A02001',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$access_token
        ];
    }
}
