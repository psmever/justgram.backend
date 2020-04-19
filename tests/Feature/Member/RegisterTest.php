<?php

namespace Tests\Feature\Member;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class RegisterTest extends TestCase
{
    protected $api_endpoint;
    protected $faker;


    public function setUp(): void {
        parent::setUp();

        $this->api_endpoint = '/api/justgram/v1/register';
        $this->faker = \Faker\Factory::create();
    }

    // 이름이 없을때.
    public function test_user_register_error_not_username()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "username" => NULL,
            "email" => $this->faker->email,
            "password" => "password",
            "confirm_password" => "password"
        ]);
        $response->assertStatus(400);
    }

    // 이메일이 없을떄.
    public function test_user_register_error_not_email()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "username" => $this->faker->name,
            "email" => '',
            "password" => "password",
            "confirm_password" => "password"
        ]);
        $response->assertStatus(400);
    }

    // 패스워드가 없을때.
    public function test_user_register_error_not_password()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "username" => $this->faker->name,
            "email" => $this->faker->email,
            "confirm_password" => "password"
        ]);
        $response->assertStatus(400);
    }

    // 패스워드 확인이 없을때.
    public function test_user_register_error_not_confirm_password()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "username" => $this->faker->name,
            "email" => $this->faker->email,
            "password" => "password",
        ]);
        $response->assertStatus(400);
    }

    // 패스워드가 다를떄.
    public function test_user_register_error_not_bad_confirm_password()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->postjson($this->api_endpoint, [
            "username" => $this->faker->name,
            "email" => $this->faker->email,
            "password" => "password1",
            "confirm_password" => "password2"
        ]);
        $response->assertStatus(400);
    }

    // 회원 가입 및 테스트 이메일 인증.
    public function test_user_register()
    {
        $email = $this->faker->email;

        $response = $this->withHeaders($this->getDefaultHeaders())->json('POST', $this->api_endpoint, [
            "username" => $this->faker->name,
            "email" => $email,
            "password" => "password",
            "confirm_password" => "password"
        ]);
        // $response->dump();
        $response->assertStatus(200);

        $response = $this->withHeaders($this->getDefaultHeaders())->json('POST', '/api/justgram/v1/login', [
            "email" => $email,
            "password" => "password"
        ]);
        $response->assertStatus(401);

        $task = DB::table('tbl_email_auth_master')->first();
        $response = $this->get("/front/v1/auth/email_auth?code=".$task->auth_code);
        $response->assertStatus(200);

        $response = $this->withHeaders($this->getDefaultHeaders())->json('POST', '/api/justgram/v1/login', [
            "email" => $email,
            "password" => "password"
        ]);
        $response->assertStatus(200);

    }
}
