<?php

namespace Tests\Feature\Member;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    protected $api_endpoint;
    protected $user;

    public function setUp(): void {
        parent::setUp();

        $this->api_endpoint = '/api/justgram/v1/login';
        $this->user = $this->getUser();
    }

    // 이메일 없을떄.
    public function test_user_login_error_not_email()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "password" => 'password'
        ]);
        $response->assertStatus(401);
    }

    //패스워드 없을떄.
    public function test_user_login_error_not_password()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "email" => $this->user->email,
        ]);
        $response->assertStatus(401);
    }

    // 없는 아이디
    public function test_user_login_error_bad_id()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "email" => 'asdasd',
            "password" => 'password'
        ]);
        $response->assertStatus(401);
    }

    // 패스워드 없을떄.
    public function test_user_login_error_bad_password()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "email" => $this->user->email,
        ]);
        $response->assertStatus(401);
    }

    // 정상 처리.
    public function testLogin()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "email" => $this->user->email,
            "password" => 'password'
        ]);
        // $response->dump();
        $response->assertStatus(200);
    }
}
