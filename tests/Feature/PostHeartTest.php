<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostHeartTest extends TestCase
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

    // 하트 주기 글번호 없을떄.
    public function test_post_heart_error_nothing_post_id()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/heart', [
        ]);
        $response->assertStatus(400);
    }

    // 하트 주기 테스트 없을글에 하트 줄떄.
    public function test_post_heart_error_nothing_post()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/heart', [
            "post_id" => 1000000,
        ]);
        $response->assertStatus(400);
    }

    // 하트 주기 테스트 정상.
    public function test_post_heart()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
            "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
            "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);

        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/heart', [
            "post_id" => 1,
        ]);
        // $response->dump();
        $response->assertStatus(200);
    }

    // 하트 취소. 테스트.
    public function test_post_heart_delete()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
            "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
            "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);

        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post/heart', [
            "post_id" => 1,
        ]);
        // $response->dump();
        $response->assertStatus(200);

        // 하트 취소.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/post/heart', [
            // "post_id" => 1,
        ]);
        $response->assertStatus(400);

        // 하트 취소.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/post/heart', [
            "post_id" => 100,
        ]);
        $response->assertStatus(400);


        // 하트 취소.
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->deletejson('/api/justgram/v1/post/heart', [
            "post_id" => 1,
        ]);
        $response->assertStatus(200);
    }
}
