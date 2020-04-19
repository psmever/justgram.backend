<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SystemTest extends TestCase
{
    // 서버체크
    public function testCheckServer()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->json('GET', '/api/justgram/v1/system/server');
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => __('messages.default.success'),
            ]);
    }

    //공지 사항 체크.
    public function testCheckNotice()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->json('GET', '/api/justgram/v1/system/notice');
        $response->assertStatus(200);
    }

    // 사이트 데이터 체크.
    public function testGetSiteData()
    {
        $response = $this->withHeaders($this->getDefaultHeaders())->json('GET', '/api/justgram/v1/system/sitedata');
        $response->assertStatus(200);
    }
}
