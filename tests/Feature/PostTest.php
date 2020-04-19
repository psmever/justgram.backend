<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
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

    // 글 리스트 확인. 글 등록 안했을떄.
    public function test_post_list_confirm()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson('/api/justgram/v1/post');
        // $response->dump();
        $response->assertStatus(200);
    }

    // 글등록 테스트 내용 없을떄.
    public function test_post_create_error_nothing_contents()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                // "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);
    }

    // 글등록 테스트 이미지 없을떄.
    public function test_post_create_error_nothing_image()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            // "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);
    }

    // 글등록 테스트 테그 없을떄.
    public function test_post_create_error_nothing_tag()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
            // "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
            "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);
    }

    // 글등록 테스트.
    public function test_post_create()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
            "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
            "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(200);
    }

    // 글 리스트 확인. 글 등록 했을떄.
    public function test_post_list()
    {
        $response = $this->withHeaders($this->getAuthHeaders($this->access_token))->getjson('/api/justgram/v1/post');
        $response->assertStatus(200);
    }

}

