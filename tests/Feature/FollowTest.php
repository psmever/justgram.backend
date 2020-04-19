<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    protected $user;
    protected $faker;
    protected $access_token;
    protected $refresh_token;

    public function setUp(): void
    {
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

    // 팔로우 추가 테스트. 대상 없을떄.
    public function test_follow_create_error_nothing_target_id()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/user/follow');
        $response->assertStatus(400);
    }

    // 팔로우 추가 테스트. 없는 대상 일떄.
    public function test_follow_create_error_nothing_target()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/user/follow', [
            "target_user_id" => 100,
        ]);
        $response->assertStatus(400);
    }

    // 팔로우 추가 테스트.
    public function test_follow_create()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(200);
    }


    // 팔로우 삭제 테스트. 대상 없을때.
    public function test_follow_delete_nothing_target_id()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/user/follow');
        $response->assertStatus(400);
    }

    // 팔로우 삭제 테스트. 없는 대상 일때..
    public function test_follow_delete_nothing_target()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/user/follow', [
            "target_user_id" => 100,
        ]);
        $response->assertStatus(400);
    }

    // 팔로우 삭제 테스트. 등록 되어 있지 않은 사용자를 삭제 할때.
    public function test_follow_delete_error_nothing_add()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(400);
    }

    // 팔로우 삭제 테스트.
    public function test_follow_delete()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(200);

        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(200);
    }

    // following 리스트
    public function test_user_following_list()
    {
        $user_name = $this->user->user_name;
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/following");
        $response->assertStatus(200);
    }

    // following 리스트
    public function test_user_followers_list()
    {
        $user_name = $this->user->user_name;
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson("/api/justgram/v1/user/${user_name}/followers");
        $response->assertStatus(200);
    }
}
