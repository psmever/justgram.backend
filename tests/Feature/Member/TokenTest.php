<?php

namespace Tests\Feature\Member;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokenTest extends TestCase
{
    protected $user;
    protected $access_token;
    protected $refresh_token;

    public function setUp(): void {
        parent::setUp();

        $this->user = $this->getUser();

        $response = $this->withHeaders($this->getDefaultHeaders())->postjson('/api/justgram/v1/login', [
            "email" => $this->user->email,
            "password" => 'password'
        ]);
        $response->assertStatus(200);

        $this->access_token = $response['access_token'];
        $this->refresh_token = $response['refresh_token'];
    }

    // 정상 토큰이 아닐떄.
    public function test_login_token_refresh_bad()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))
            ->postjson('/api/justgram/v1/token/refresh', [
                "refresh_token" => "1".$this->refresh_token
            ]);
        $response->assertStatus(500)->assertJson([
            'error_message' => __('auth.bad_token')
        ]);
    }

    // 토큰 리프래시
    public function test_login_token_refresh()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/token/refresh', [
            "refresh_token" => $this->refresh_token
        ]);
        $response->assertStatus(200);

        $this->access_token = $response['access_token'];
        $this->refresh_token = $response['refresh_token'];
    }
}
