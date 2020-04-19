<?php

namespace Tests\Feature\Member;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ProfileTest extends TestCase
{
    protected $user;
    protected $faker;
    protected $access_token;
    protected $refresh_token;

    public function setUp(): void {
        parent::setUp();

        $this->user = $this->getUser();
        $this->faker = \Faker\Factory::create();

        $response = $this->withHeaders($this->getDefaultHeaders())->postjson('/api/justgram/v1/login', [
            "email" => $this->user->email,
            "password" => 'password'
        ]);
        $response->assertStatus(200);

        $this->access_token = $response['access_token'];
        $this->refresh_token = $response['refresh_token'];
    }

    // 정상 토큰이 아닐떄.
    public function test_user_profile_bad()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token."1"))->getjson('/api/justgram/v1/my/profile');
        $response->assertStatus(401)->assertJson([
            'error_message' => __('auth.login.need_login')
        ]);
    }

    // 내 프로필 정보. (초기 데이터)
    public function test_user_profile()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson('/api/justgram/v1/my/profile');
        $response->assertStatus(200);
    }

    // 사용자 프로필 ( 프로필 이미지 없을때.)
    public function test_user_profile_nothing()
    {
        $user_name = $this->user->user_name;
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/profile");
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_image_data')
        ]);
    }

    // 없는사용자 프로필 정보 요청 했을때.
    public function test_user_profile_nothing_user_profile_data()
    {
        // 사용자 프로필 데이터 없을떄.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson('/api/justgram/v1/user/aaaaaaaaa/profile');
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.user')
        ]);
    }

    // 프로필 이미지 데이터가 없을때..
    public function test_user_profile_nothing_profile_data()
    {
        $user_name = $this->user->user_name;
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/profile");
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_image_data')
        ]);
    }

    // 사용자 프로필 이미지 업데이트 에러
    public function test_user_profile_image_update_error()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->putjson('/api/justgram/v1/my/profile/image', [
            // "public_id" => "justgram_image/gqgedyzmobpnadhnhkdz",
            "version" => "1582725646",
            "signature" => "7cc3ced8d153ced291e5b0bf837398bf7c4d2eea",
            "width" => "512",
            "height" => "342",
            "format" => "jpg",
            "resource_type" => "image",
            "created_at" => "2020-02-26T14:00:46Z",
            "tags" => "",
            "bytes" => "44891",
            "type" => "upload",
            "etag" => "d98ce8fb59d10bd3a0b5fbc9aa0dc50e",
            "placeholder" => "false",
            "url" => "http://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "secure_url" => "https://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "access_mode" => "public",
            "original_filename" => "unnamed"
        ]);
        $response->assertStatus(400);
    }

    // 사용자 프로필 이미지 업데이트. 테스트
    public function test_user_profile_image_update()
    {
        $user_name = $this->user->user_name;

        // 프로필 이미지 업데이트
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->putjson('/api/justgram/v1/my/profile/image', [
            "public_id" => "justgram_image/gqgedyzmobpnadhnhkdz",
            "version" => "1582725646",
            "signature" => "7cc3ced8d153ced291e5b0bf837398bf7c4d2eea",
            "width" => "512",
            "height" => "342",
            "format" => "jpg",
            "resource_type" => "image",
            "created_at" => "2020-02-26T14:00:46Z",
            "tags" => "",
            "bytes" => "44891",
            "type" => "upload",
            "etag" => "d98ce8fb59d10bd3a0b5fbc9aa0dc50e",
            "placeholder" => "false",
            "url" => "http://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "secure_url" => "https://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "access_mode" => "public",
            "original_filename" => "unnamed"
        ]);
        $response->assertStatus(200);

        //  프로프리 데이터 이미지는 있지만 데이터가 없어서 에러.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/profile");
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_data')
        ]);

        // 프로필 정보 업데이트
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->putjson('/api/justgram/v1/my/profile', [
            "name" => $this->faker->name,
            "web_site" => $this->faker->url,
            "bio" => $this->faker->text,
            "phone_number" => $this->faker->phoneNumber,
            "gender" => "A21010"
        ]);
        $response->assertStatus(200);

        // 확인.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/profile");
        $response->assertStatus(200);
    }
}
