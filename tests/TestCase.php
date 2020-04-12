<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getDefaultHeaders() : array
    {
        return [
            'Request-Client-Type' => 'A02001',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}
