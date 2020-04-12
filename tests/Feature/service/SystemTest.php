<?php

namespace Tests\Feature\service;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class SystemTest extends TestCase
{
    protected $defaultHeader;

    public function setUp(): void{
        parent::setUp();
        $this->defaultHeader = TestCase::getDefaultHeaders();
        Artisan::call('migrate',['-vvv' => true]);
        Artisan::call('passport:install',['-vvv' => true]);
        Artisan::call('db:seed',['-vvv' => true]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * 서버체크
     *
     * @return void
     */
    public function testCheckServer()
    {
        $response = $this->withHeaders($this->defaultHeader)->json('GET', '/api/justgram/v1/system/server');
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => __('messages.default.success'),
            ]);
    }

    /**
     * 공지 사항 체크.
     *
     * @return void
     */
    public function testCheckNotice()
    {
        $response = $this->withHeaders($this->defaultHeader)->json('GET', '/api/justgram/v1/system/notice');
        $response->assertStatus(200);
    }

    /**
     * 사이트 데이터 체크.
     *
     * @return void
     */
    public function testGetSiteData()
    {
        $response = $this->withHeaders($this->defaultHeader)->json('GET', '/api/justgram/v1/system/sitedata');
        $response->assertStatus(200);
    }

}
