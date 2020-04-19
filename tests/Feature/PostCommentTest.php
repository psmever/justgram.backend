<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
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

    // 코멘트 등록 테스트 데이터 없을떄.
    public function test_comment_create_error_nothing_data()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/comment', [

        ]);
        $response->assertStatus(400);
    }

    // 코멘트 등록 테스트 글 번호 없을때.
    public function test_comment_create_error_nothing_post_id()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/comment', [
            "contents" => $this->faker->text
        ]);
        $response->assertStatus(400);
    }

    // 코멘트 등록 테스트 글 번호 없을때.
    public function test_comment_create_error_nothing_contents()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/comment', [
            "post_id" => 1,
        ]);
        $response->assertStatus(400);
    }

    // 코멘트 등록 테스트
    public function test_comment_create()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/comment', [
            "post_id" => 1,
            "contents" => $this->faker->text
        ]);
        $response->assertStatus(200);
    }
}
